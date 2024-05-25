<?php

namespace SAAS\Domain\Pages\Repositories\Eloquent;

use Illuminate\Support\Arr;
use SAAS\App\Repositories\Eloquent\Criteria\EagerLoad;
use SAAS\App\Repositories\RepositoryAbstract;
use SAAS\Domain\Pages\Models\Page;

class PageRepository extends RepositoryAbstract
{
    /**
     * Define the repository's entity.
     *
     * @return string
     */
    public function entity()
    {
        return Page::class;
    }

    /**
     * Find the first record with given "column" value without throwing any error.
     *
     * @param  string  $column
     * @param  mixed  $value
     * @return mixed
     */
    public function findFirstSilently($column, $value)
    {
        return $this->entity->where($column, $value)->first();
    }

    /**
     * Create a record for a given entity.
     *
     * @param  array  $data
     * @param  array  $relations
     * @return \SAAS\Domain\Pages\Models\Page
     */
    public function create(array $data, array $relations = [])
    {
        /** @var \SAAS\Domain\Pages\Models\Page $page */
        $page = $this->entity;

        $this->pageMake($data, $page);

        $page->save();

        if (Arr::has($relations, 'main_image')) {
            $id = Arr::get($relations, 'main_image');
            $page = $page->attachMedia($id, 'main_image');
        }

        return $page;
    }

    /**
     * Update a record of a given entity.
     *
     * @param  int  $id
     * @return \SAAS\Domain\Pages\Models\Page
     */
    public function update($id, array $data, array $relations = [])
    {
        /** @var \SAAS\Domain\Pages\Models\Page $page */
        $page = $this->withCriteria(
            new EagerLoad([
                // todo: revisit here
                // 'views',
                // 'visits',
            ])
        )->find($id);

        $this->pageMake($data, $page);

        $page->save();

        // save media
        if (($media = $relations['main_image']) ?? false) {
            $page = $page->attachMedia($media, 'main_image');
        }

        return $page;
    }

    /**
     * Make a page with given data.
     *
     * @param  array  $data
     * @param  \SAAS\Domain\Pages\Models\Page|mixed  $page
     * @return void
     */
    public function pageMake(array $data, &$page)
    {
        $page = $page->fill(
            Arr::except($data, 'themes', 'layouts', 'templates', 'order', 'page')
        );

        foreach (['themes', 'layouts', 'templates'] as $item) {
            $value = Arr::get($data, $item);
            $page->setAttribute($item, ! empty($value) ? $value : null);
        }

        // set page order
        $page = $page->setPageOrder(Arr::get($data, 'order'), Arr::get($data, 'node'));
    }
}
