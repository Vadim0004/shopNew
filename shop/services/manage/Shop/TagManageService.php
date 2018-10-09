<?php

namespace shop\services\manage\Shop;

use shop\entities\Shop\Tag;
use shop\forms\manage\Shop\TagForm;
use shop\repositories\Shop\TagRepository;

class TagManageService
{
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function create(TagForm $form): Tag
    {
        $tag = Tag::create(
            $form->name,
            $form->slug
        );
        $this->tagRepository->save($tag);
        return $tag;
    }

    public function edit($id, TagForm $form): void
    {
        $tag = $this->tagRepository->get($id);
        $tag->edit(
            $form->name,
            $form->slug
        );
        $this->tagRepository->save($tag);
    }

    public function remove($id): void
    {
        $tag = $this->tagRepository->get($id);
        $this->tagRepository->remove($tag);
    }

}