<?php

namespace App\Services\Digitalocean;


class Droplet
{
    /**
     * Login // Get token
     * 
     * @param array $params
     */
    public function getToken($params = [], $token)
    {
        return $this->makeRequest('POST', 'droplets', $params, $token);
    }
    /**
     * Creates single server
     *
     * @param array $params
     */
    public function createSingleServer($params = [], $token)
    {
        return $this->makeRequest('POST', 'droplets', $params, $token);
    }

    /**
     * Retrive Single Droplet
     * 
     * @param int $id
     */
    public function getDropletById($id, $token)
    {
        return $this->makeRequest('GET', 'droplets/' . $id, [], $token);
    }

    /**
     * Delete Droplet by ID
     * 
     * @param int $id
     */
    public function deleteDropletById($id, $token)
    {
        return $this->makeRequest('delete', 'droplets/' . $id, [], $token);
    }

    /**
     * Resize Droplet by ID
     * https://docs.digitalocean.com/reference/api/api-reference/#operation/dropletActions_list
     * @param int $id
     */
    public function actionVolume($id, $token, $params = [])
    {
        return $this->makeRequest('post', 'droplets/' . $id, $params, $token);
    }

    /**
     * Reboot Droplet by ID
     * https://docs.digitalocean.com/reference/api/api-reference/#operation/dropletActions_list
     * @param int $id
     */
    public function actionReboot($id, $token, $params = ['type' => "reboot"])
    {
        return $this->makeRequest('post', 'droplets/' . $id . '/actions', $params, $token);
    }

    public function getAccountInfo($token)
    {
        return $this->makeRequest('get', 'account', [], $token);
    }
}
