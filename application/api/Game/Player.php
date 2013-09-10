<?php

class Game_Player
{

    /**
     * @param array $params
     * @return array
     */
    public function read($params)
    {
        if ($params['id']) {
            return array(
                'success' => true,
                'Player' => $this->_load('Player', $params['id'])
            );
        } else {
            return array(
                'success' => true,
                'Player' => $this->_load('Player')
            );
        }
    }

    /**
     * @param array $params
     * @return array
     */
    public function create($params)
    {
        return array(
            'success' => true,
            'Player' => $this->_create('Player', $params)
        );
    }

    /**
     * @param array $params
     * @return array
     */
    public function update($params)
    {
        return array(
            'success' => true,
            'Player' => array(
                'id' => 0,
                'name' => $params['name'],
                'surname' => $params['surname'],
                'age' => $params['age'],
                'nickname' => $params['nickname']
            )
        );
    }

    /**
     * @param $id
     * @return array
     */
    public function load($id)
    {
        return array(
            'success' => true,
            'data' => $this->_load('Player', $id)
        );
    }

    /**
     * @param $id
     * @param $name
     * @param $surname
     * @param $nickname
     * @param $age
     * @formHandler
     * @return array
     */
    public function submit(
        $id,
        $name,
        $surname,
        $nickname,
        $age
    )
    {
        if($id){
            $return = $this->_update('Player', $id, array(
                'name' => $name,
                'surname' => $surname,
                'age' => $age,
                'nickname' => $nickname,
            ));
        }else{
            $return = $this->_create('Player', array(
                'name' => $name,
                'surname' => $surname,
                'age' => $age,
                'nickname' => $nickname,
            ));
        }

        return array(
            'success' => true,
            'data' => $return
        );
    }

    /**
     * @param array $params
     * @return array
     */
    public function destroy($params)
    {
        return array(
            'success' => true,
            'Player' => array(
                'id' => null,
                'name' => $params['name'],
                'surname' => $params['surname'],
                'age' => $params['age'],
                'nickname' => $params['nickname']
            )
        );
    }

    /**
     * @param $name
     * @param array $data
     * @return array
     */
    private function _create($name, array $data)
    {
        $namespace = new Zend_Session_Namespace('storage');
        isset($namespace->$name) || $namespace->$name = array();
        $data['id'] = count($namespace->$name);
        array_push($namespace->$name, $data);
        return $data;
    }

    /**
     * @param $name
     * @param $id
     * @param array $data
     * @return array
     */
    private function _update($name, $id, array $data){
        $return = array();
        $namespace = new Zend_Session_Namespace('storage');
        if (is_array($namespace->$name)) {
            foreach ($namespace->$name as $key => &$row) {
                if ($key === (int)$id) {
                    $data['id'] = $id;
                    $row = $data;
                    $return = $data;
                }
            }
        }
        return $return;
    }

    /**
     * @param $name
     * @param $id
     * @return array
     */
    private function _load($name, $id = -1)
    {
        $return = array();
        $namespace = new Zend_Session_Namespace('storage');
        if (is_array($namespace->$name)) {
            if ($id > -1) {
                foreach ($namespace->$name as $key => $row) {
                    if ($key === (int)$id) {
                        $return = $row;
                    }
                }
            } else {
                $return = $namespace->$name;
            }
        }
        return $return;
    }
}