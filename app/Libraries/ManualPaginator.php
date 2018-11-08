<?php

namespace App\Libraries;

use ArrayAccess;
use Countable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\ForwardsCalls;
use IteratorAggregate;
use JsonSerializable;

class ManualPaginator implements Arrayable, ArrayAccess, Countable, IteratorAggregate, JsonSerializable, Jsonable
{
    use ForwardsCalls;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $items;

    /**
     * @var int
     */
    protected $perPage;

    /**
     * @var int
     */
    protected $currentPage = 1;

    /**
     * @var int
     */
    protected $total;

    /**
     * @var int
     */
    protected $lastPage;

    /**
     * @param  mixed  $items
     * @param  int  $perPage
     * @return void
     */
    public function __construct($items, $perPage)
    {
        $this->items = $items instanceof Collection ? $items : Collection::make($items);
        $this->total = $this->items->count();
        $this->perPage = $perPage;
        $this->lastPage = max((int) ceil($this->total / $perPage), 1);
    }

    /**
     * @return array
     */
    public function items()
    {
        return $this->getCollection()->toArray();
    }

    /**
     * @return int
     */
    public function perPage()
    {
        return $this->perPage;
    }

    /**
     * @return bool
     */
    public function hasPages()
    {
        return $this->currentPage() != 1 || $this->hasMorePages();
    }

    /**
     * @return bool
     */
    public function onFirstPage()
    {
        return $this->currentPage() <= 1;
    }

    /**
     * @return int
     */
    public function currentPage()
    {
        return $this->currentPage;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return $this->items->getIterator();
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->items->isEmpty();
    }

    /**
     * @return bool
     */
    public function isNotEmpty()
    {
        return $this->items->isNotEmpty();
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->items->count();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCollection()
    {
        return $this->getCollectionForPage($this->currentPage());
    }

    /**
     * @param  int  $page
     * @return \Illuminate\Support\Collection
     */
    public function getCollectionForPage($page)
    {
        return $this->items->slice(($page - 1) * $this->perPage(), $this->perPage());
    }

    /**
     * @param  \Illuminate\Support\Collection  $collection
     * @return $this
     */
    public function setCollection(Collection $collection)
    {
        $this->items = $collection;

        return $this;
    }

    /**
     * @param  mixed  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->items->has($key);
    }

    /**
     * @param  mixed  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->items->get($key);
    }

    /**
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->items->put($key, $value);
    }

    /**
     * @param  mixed  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        $this->items->forget($key);
    }

    /**
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->getCollection(), $method, $parameters);
    }

    /**
     * @return int
     */
    public function lastPage()
    {
        return $this->lastPage;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'current_page' => $this->currentPage(),
            'data' => $this->items->toArray(),
            'from' => $this->firstItem(),
            'last_page' => $this->lastPage(),
            'per_page' => $this->perPage(),
            'to' => $this->lastItem(),
            'total' => $this->total(),
        ];
    }

    /**
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @return int
     */
    public function firstItem()
    {
        return count($this->items) > 0 ? ($this->currentPage - 1) * $this->perPage + 1 : null;
    }

    /**
     * @return int
     */
    public function lastItem()
    {
        return count($this->items) > 0 ? $this->firstItem() + $this->count() - 1 : null;
    }

    /**
     * @return bool
     */
    public function hasMorePages()
    {
        return $this->currentPage() < $this->lastPage();
    }

    /**
     * @return int
     */
    public function total()
    {
        return $this->total;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function pages()
    {
        $pages = Collection::make(range(1, $this->lastPage()));

        return $pages->mapWithKeys(function ($page) {
            return [$page => $this->getCollectionForPage($page)];
        });
    }
}