<?php

class Game_Player
{

    /**
     * @param array $params
     * @return array
     */
    public function read($params)
    {
        return array(
            'success'=>true,
            'Player'=>array(
                array(
                    'id' => 0,
                    'name' => 'Sebastian',
                    'surname' => 'Widelak',
                    'age' => 24,
                    'nickname' => 'mkalafior'
                ),
                array(
                    'id' => 1,
                    'name' => 'Gal',
                    'surname' => 'Anonim',
                    'age' => 999,
                    'nickname' => 'anonymous'
                )
            )
        );
    }

    /**
     * @param array $params
     * @return array
     */
    public function create($params)
    {
        return array(
            'success'=>true,
            'Player'=>array(
                'id' => 0,
                'name' => $params['name'],
                'surname' => $params['surname'],
                'age' => $params['age'],
                'nickname' => $params['nickname']
            )
        );
    }

    /**
     * @param array $params
     * @return array
     */
    public function update($params)
    {
        return array(
            'success'=>true,
            'Player'=>array(
                'id' => 0,
                'name' => $params['name'],
                'surname' => $params['surname'],
                'age' => $params['age'],
                'nickname' => $params['nickname']
            )
        );
    }

    /**
     * @param array $params
     * @return array
     */
    public function destroy($params) {
        return array(
            'success'=>true,
            'Player'=>array(
                'id' => null,
                'name' => $params['name'],
                'surname' => $params['surname'],
                'age' => $params['age'],
                'nickname' => $params['nickname']
            )
        );
    }

}