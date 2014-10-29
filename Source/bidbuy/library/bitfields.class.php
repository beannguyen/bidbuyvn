<?php

class BitField
{
    // member variable
    protected $roles = array();
    protected $permission;

    // constructor
    public function __construct()
    {
        $this->setPermission( 0 );
    }

    /**
     * check permission for action
     * @param $action
     * @return bool
     */
    public function check( $action )
    {
        if ( array_key_exists( $action, $this->roles ) )
        {
            return ( ( $this->permission & $this->roles[$action] ) > 0);
        }
        return FALSE;
    }

    /**
     * allow user to do the action
     * @param $action
     * @return bool
     */
    public function add( $action )
    {
        if ( array_key_exists( $action, $this->roles ) )
        {
            $this->permission |= $this->roles[$action];
            return TRUE;
        }
        return FALSE;
    }

    /**
     * disallow user to do the action
     * @param $action
     * @return bool
     */
    public function remove($action)
    {
        if (array_key_exists($action, $this->roles))
        {
            $this->permission &= ~$this->roles[$action];
            return TRUE;
        }
        return FALSE;
    }

    /**
     * set permission for user
     * @param $permission
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;
    }

    /**
     * return current permission
     * @return mixed
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * get all roles
     * @return array
     */
    public function getAllRoles()
    {
        return $this->roles;
    }
}