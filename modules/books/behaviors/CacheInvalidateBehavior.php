<?php

declare(strict_types=1);

namespace modules\books\behaviors;

use Closure;
use Yii;
use yii\base\Behavior;
use yii\caching\CacheInterface;
use yii\caching\TagDependency;
use yii\db\BaseActiveRecord;

class CacheInvalidateBehavior extends Behavior
{
    public string $cacheComponent = 'cache';

    public array $tags = [];

    public Closure $func;

    private CacheInterface|null $cache = null;

    public function events(): array
    {
        return [
            BaseActiveRecord::EVENT_AFTER_DELETE => 'invalidateCache',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'invalidateCache',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'invalidateCache',
        ];
    }

    public function invalidateCache(): bool
    {
        if (!empty($this->tags)) {
            $this->invalidateTags();
        }
        if (!empty($this->func) && is_callable($this->func)) {
            call_user_func($this->func, $this->owner);
        }
        return true;
    }

    protected function invalidateTags(): void
    {
        foreach($this->tags as $tag) {
            TagDependency::invalidate(
                $this->getCache(),
                array_map(function ($tag) {
                    if (is_callable($tag)) {
                        $tag = call_user_func($tag, $this->owner);
                    }
                    return $tag;
                }, $tag)
            );
        }
    }

    protected function getCache()
    {
        if(!$this->cache) {
            $this->cache = Yii::$app->{$this->cacheComponent};
        }
        return $this->cache;
    }
}