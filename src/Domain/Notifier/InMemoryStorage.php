<?php

namespace Domain\Notifier;

class InMemoryStorage implements FetcherStorage, PersisterStorage
{
    /**
     * @var NotifierRule[]
     */
    private $data = [];

    public function getNotifierRules(): array
    {
        $toReturn = [];

        foreach ($this->data as $rule) {
            $toReturn[] = [
                'class' => get_class($rule),
                'id' => $rule->id(),
                'options' => $rule->persistConfig(),
            ];
        }

        return $toReturn;
    }

    public function persist(NotifierRule $persistableNotifierRule)
    {
        $this->data[] = $persistableNotifierRule;
    }
}