<?php

class Users_Model extends Model {

    public $pag;

    public function __construct() {
        parent::__construct();
    }

    public function usersForm($type = 'add', $id = 'null') {
        $action = ($type == 'add') ? URL . LANG . '/users/create' : URL . LANG . '/users/edit/' . $id;
        if ($type == 'edit')
            foreach ($this->getUsers($id) as $users)
                ;
        $atributes = array(
            'enctype' => 'multipart/form-data',
        );
        $form = new Zebra_Form('addUser', 'POST', $action, $atributes);

        $form->add('hidden', '_add', 'contacts');
        $form->add('label', 'label_name', 'name', 'Name');
        $form->add('text', 'name', $users['name'], array('autocomplete' => 'off', 'required' => array('error', 'First name is required!')));

        $form->add('label', 'label_email', 'email', 'Mail');
        $obj = $form->add('text', 'email', $users['email'], array('autocomplete' => 'off'), array('error', 'Email is required!'), array('error', 'Email address seems to be invalid!'));

        $form->add('label', 'label_role', 'role', 'Rol');
        $obj = $form->add('select', 'role', $users['role'], array('autocomplete' => 'off'));
        foreach ($this->getRoles() as $key => $value) {
            $obt[$value['id']] = $value['name'];
        }
        $obj->add_options($obt);
        unset($obt);

        $form->add('label', 'label_password', 'password', 'Choose a password');
        $obj = $form->add('password', 'password');

        if ($type == 'add') {
            $obj->set_rule(array(
                'required' => array('error', 'Password is required!'),
                'length' => array(6, 20, 'error', 'The password must have between 6 and 10 characters'),
            ));
        } else {
            $obj->set_rule(array(
                'length' => array(4, 20, 'error', 'The password must have between 4 and 10 characters'),
            ));
        }
        $form->add('note', 'note_password', 'password', 'Password must be have between 6 and 10 characters.');
        $form->add('label', 'label_confirm_password', 'confirm_password', 'Confirm password');
        $obj = $form->add('password', 'confirm_password');
        $obj->set_rule(array(
            'compare' => array('password', 'error', 'Password not confirmed correctly!')
        ));
        $form->add('label', 'label_state', 'state', 'State:');
        $form->add('checkboxes', 'state', array(
            '1' => 'Active',
                ), $users['status']);

        $form->add('submit', '_btnsubmit', 'Submit');
        $form->validate();
        return $form;
    }

    public function getUsers($id) {
        return $this->db->select("SELECT * FROM " . DB_PREFIX . "users WHERE id=" . $id);
    }

    public function getRoles() {
        return $this->db->select("SELECT * FROM " . DB_PREFIX . "roles order by id");
    }

    public function getRole($id) {
        $role = $this->db->select("SELECT * FROM " . DB_PREFIX . "roles WHERE id=" . $id);
        return $role[0]['name'];
    }

    public function getUsersList($pag, $maxpp, $order = 'id') {
        $min = $pag * $maxpp - $maxpp;
        return $this->db->select("SELECT * FROM " . DB_PREFIX . "users ORDER by " . $order . " LIMIT " . $min . "," . $maxpp);
    }

    public function usersToTable($lista, $order) {
        $order = explode(' ', $order);
        $orden = (strtolower($order[1]) == 'desc') ? ' ASC' : ' DESC';
        $b['sort'] = true;
        $b['title'] = array(
            array(
                "title" => "Id",
                "link" => URL . LANG . '/users/lista/' . $this->pag . '/id' . $orden,
                "width" => "5%"
            ), array(
                "title" => "Name",
                "link" => URL . LANG . '/users/lista/' . $this->pag . '/firstname' . $orden,
                "width" => "10%"
            ), array(
                "title" => "Email",
                "link" => URL . LANG . '/users/lista/' . $this->pag . '/email' . $orden,
                "width" => "30%"
            ), array(
                "title" => "Rol",
                "link" => URL . LANG . '/users/lista/' . $this->pag . '/role' . $orden,
                "width" => "5%"
            ), array(
                "title" => "Options",
                "link" => "#",
                "width" => "10%"
        ));
        foreach ($lista as $key => $value) {
            $b['values'][] = array(
                        "id" => $value['id'],
                        "name" => $value['name'],
                        "email" => $value['email'],
                        "role" => $this->getRole($value['role']),
                        "Options" => '<a href="' . URL . LANG . '/users/editCreateUser/' . $value['id'] . '"><button title="Edit" type="button" class="edit"></button></a><button type="Delete" type="button" type="button" class="delete" onclick="borrarPackList(\'' . $value['id'] . '\');"></button>'
            );
        }
        return $b;
    }

    public function create() {
        $data = array(
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'role' => $_POST['role'],
            'status' => 1
        );
        if (isset($_POST['password']) && $_POST['password'] != '')
            $data['password'] = Hash::create('sha256', $_POST['password'], HASH_PASSWORD_KEY);
        return $this->db->insert(DB_PREFIX . 'users', $data);
    }

    public function edit($id) {
        $data = array(
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'role' => $_POST['role'],
            'status' => ($_POST['state'] == 1) ? 1 : 0,
        );
        if (isset($_POST['password']) && $_POST['password'] != '')
            $data['password'] = Hash::create('sha256', $_POST['password'], HASH_PASSWORD_KEY);
        $this->db->update(DB_PREFIX . 'users', $data, "`id` = '{$id}'");
    }

    public function delete($id) {
        $this->db->delete(DB_PREFIX . 'users', "`id` = {$id}");
    }

    public function run() {
        $sth = $this->db->prepare("SELECT * FROM " . DB_PREFIX . "users WHERE 
                email = :email AND password = :password and status=1");
        $sth->execute(array(
            ':email' => $_POST['login'],
            ':password' => Hash::create('sha256', $_POST['password'], HASH_PASSWORD_KEY)
        ));
        $data = $sth->fetch();
        $count = $sth->rowCount();
        if ($count > 0) {
            // login
            Session::init();
            Session::set('role', $data['role']);
            Session::set('loggedIn', true);
            Session::set('userid', $data['id']);
            header('location: ' . URL . 'works');
        } else {
            header('location: ' . URL);
        }
    }

    public function out() {
        Session::set('role', '');
        Session::set('loggedIn', false);
        Session::set('userid', '');
        header('location: ' . URL);
        Session::destroy();
    }

}
