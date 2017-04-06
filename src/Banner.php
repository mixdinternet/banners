<?php

namespace Mixdinternet\Banners;

use Venturecraft\Revisionable\RevisionableTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Codesleeve\Stapler\ORM\EloquentTrait;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Banner extends Model implements StaplerableInterface
{
    use SoftDeletes, RevisionableTrait, EloquentTrait;

    protected $revisionCreationsEnabled = true;

    protected $revisionFormattedFieldNames = [
        'name' => 'nome'
        , 'star' => 'destaque'
        , 'description' => 'descrição'
        , 'target' => 'Abrir o link'
        , 'published_at' => 'data de publicação'
        , 'until_then' => 'vencimento da publicação'
    ];

    protected $revisionFormattedFields = [
        'star' => 'boolean:Não|Sim',
    ];

    protected $dates = [
        'deleted_at', 'published_at', 'until_then'
    ];

    protected $fillable = ['status'
        , 'star', 'name', 'place', 'description', 'link'
        , 'target', 'image_desktop', 'image_tablet', 'image_mobile'
        , 'published_at', 'until_then', 'image'
    ];

    public function __construct(array $attributes = [])
    {
        $place = last(explode('/', request()->server()['REQUEST_URI'])); #request()->route('place');

        $this->hasAttachedFile('image_desktop', [
            'styles' => [
                'crop' => function ($file, $imagine) {
                    $image = $imagine->open($file->getRealPath());
                    if (request()->input('crop.image_desktop.w') >= 0 && request()->input('crop.image_desktop.y') >= 0) {
                        $image->crop(new \Imagine\Image\Point(request()->input('crop.image_desktop.x'), request()->input('crop.image_desktop.y'))
                            , new \Imagine\Image\Box(request()->input('crop.image_desktop.w'), request()->input('crop.image_desktop.h')));
                    }
                    return $image;
                }
            ],
            'default_url' => 'http://placehold.it/' . config('mbanners.places.' . $place . '.desktop.width') . 'x' . config('mbanners.places.' . $place . '.desktop.height'),
        ]);

        if(config('mbanners.places.' . $place . '.tablet') !== false){
            $this->hasAttachedFile('image_tablet', [
                'styles' => [
                    'crop' => function ($file, $imagine) {
                        $image = $imagine->open($file->getRealPath());
                        if (request()->input('crop.image_tablet.w') >= 0 && request()->input('crop.image_tablet.y') >= 0) {
                            $image->crop(new \Imagine\Image\Point(request()->input('crop.image_tablet.x'), request()->input('crop.image_tablet.y'))
                                , new \Imagine\Image\Box(request()->input('crop.image_tablet.w'), request()->input('crop.image_tablet.h')));
                        }
                        return $image;
                    }
                ],
                'default_url' => 'http://placehold.it/' . config('mbanners.places.' . $place . '.tablet.width') . 'x' . config('mbanners.places.' . $place . '.tablet.height'),
            ]);
        }

        if(config('mbanners.places.' . $place . '.mobile') !== false) {
            $this->hasAttachedFile('image_mobile', [
                'styles' => [
                    'crop' => function ($file, $imagine) {
                        $image = $imagine->open($file->getRealPath());
                        if (request()->input('crop.image_mobile.w') >= 0 && request()->input('crop.image_mobile.y') >= 0) {
                            $image->crop(new \Imagine\Image\Point(request()->input('crop.image_mobile.x'), request()->input('crop.image_mobile.y'))
                                , new \Imagine\Image\Box(request()->input('crop.image_mobile.w'), request()->input('crop.image_mobile.h')));
                        }
                        return $image;
                    }
                ],
                'default_url' => 'http://placehold.it/' . config('mbanners.places.' . $place . '.mobile.width') . 'x' . config('mbanners.places.' . $place . '.mobile.height'),
            ]);
        }

        parent::__construct($attributes);
    }

    public static function boot()
    {
        parent::boot();

        static::bootStapler();
    }

    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = Carbon::createFromFormat('d/m/Y H:i', $value)
            ->toDateTimeString();
    }

    public function setUntilThenAttribute($value)
    {
        $this->attributes['until_then'] = null;
        if ($value) {
            $this->attributes['until_then'] = Carbon::createFromFormat('d/m/Y H:i', $value)
                ->toDateTimeString();
        }
    }

    public function scopeSort($query, $fields = [])
    {
        if (count($fields) <= 0) {
            $fields = [
                'status' => 'asc'
                , 'star' => 'desc'
                , 'published_at' => 'desc'
                , 'name' => 'asc'
            ];
        }

        if (request()->has('field') && request()->has('sort')) {
            $fields = [request()->get('field') => request()->get('sort')];
        }

        foreach ($fields as $field => $order) {
            $query->orderBy($field, $order);
        }
    }

    public function scopeActive($query)
    {
        $query->where('status', 'active')
            ->where('published_at', '<=', Carbon::now())
            ->where(function ($query) {
                $query->where('until_then', '>=', Carbon::now())
                    ->orWhere('until_then');
            });
    }

    public function scopeRand($query)
    {
        $query->active()->orderByRaw("RAND()");
    }

    # revision
    public function identifiableName()
    {
        return $this->name;
    }
}
