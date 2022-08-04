<?php

namespace Modules\Expansion\Services\States;

use SM\StateMachine\StateMachine;

class StateMachineManager
{

    public function factory(): StateMachine
    {
        $config = [
            'graph'         => 'myGraphMap',
            'property_path' => 'defaultState',
            'states'        => [
                'start',
                'a-item',
                'b-item',
                'c-item',
                'finished',
                'cancelled',
            ],
            'transitions'   => [
                'init'   => [
                    'from' => ['start'],
                    'to'   => 'a-item',
                ],
                'a-to-b' => [
                    'from' => ['a-item'],
                    'to'   => 'b-item',
                ],
                'a-to-c' => [
                    'from' => ['a-item'],
                    'to'   => 'c-item',
                ],
                'cancel' => [
                    'from' => ['a-item', 'b-item', 'c-item'],
                    'to'   => 'canceled',
                ],
                'finish' => [
                    'from' => ['a-item', 'b-item', 'c-item'],
                    'to'   => 'finished',
                ],
            ],
            'callbacks'     => [
                'guard'  => [
                    'to-finish' => [
                        'to' => ['finished'],
                        'do' => function () {
                            var_dump('[trigger] finished');
                            return true;
                        }
                    ],
                ],
                'before' => [
                    'to-finish' => [
                        'on' => ['finish'],
                        'do' => function () {
                            var_dump('[trigger] finish before');
                        }
                    ],
                ],
                'after'  => [
                    'on-finish' => [
                        'on' => ['finish'],
                        'do' => function () {
                            var_dump('[trigger] finish after');
                        }
                    ],
                    'to-finish' => [
                        'to' => ['finished'],
                        'do' => function () {
                            var_dump('[trigger] finished after');
                        }
                    ],
                ],
            ],
        ];

        $stateMachine = new StateMachine(new DomainObject(), $config);

        echo '<pre>';
        //
        var_dump($stateMachine->getState());
        var_dump($stateMachine->can('init'));
        $stateMachine->apply('init');
        //
        var_dump($stateMachine->getState());
        var_dump($stateMachine->can('a-to-b'));
        $stateMachine->apply('a-to-b');
        //
        var_dump($stateMachine->getState());
        $stateMachine->apply('finish');
        //
        var_dump($stateMachine->getState());

        exit;
        return $stateMachine;
    }

}
