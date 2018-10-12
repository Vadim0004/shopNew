<?php

namespace shop\services\manage\Shop;

use shop\repositories\Shop\CharacteristicRepository;
use shop\forms\manage\Shop\CharacteristicForm;
use shop\entities\Shop\Characteristic;

class CharacteristicManageService
{
    private $characteristicRepository;

    public function __construct(CharacteristicRepository $characteristicRepository)
    {
        $this->characteristicRepository = $characteristicRepository;
    }

    public function create(CharacteristicForm $form): Characteristic
    {
        $characteristic = Characteristic::create(
            $form->name,
            $form->type,
            $form->required,
            $form->default,
            $form->variants,
            $form->sort
        );
        $this->characteristicRepository->save($characteristic);
        return $characteristic;
    }

    public function edit($id, CharacteristicForm $form): void
    {
        $characteristic = $this->characteristicRepository->get($id);
        $characteristic->edit(
            $form->name,
            $form->type,
            $form->required,
            $form->default,
            $form->variants,
            $form->sort
        );
        $this->characteristicRepository->save($characteristic);
    }

    public function remove($id): void
    {
        $characteristic = $this->characteristicRepository->get($id);
        $this->characteristicRepository->remove($characteristic);
    }

}