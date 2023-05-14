<?php

namespace App\Services;

use App\Services\Api;

class SkeletonService extends Api
{
    /**
     * Login // Get token
     * 
     * @param array $params
     */
    public function getToken($params = [])
    {
        return $this->makeRequest('POST', 'token', $params);
    }

    /**
     * Retrive author
     *
     * @param array $params
     */
    public function fetchAuthors($params = [], $token)
    {
        return $this->makeRequest('GET', 'authors', $params, $token);
    }

    /**
     * Creates author
     *
     * @param array $params
     */
    public function createAuthor($params = [], $token)
    {
        return $this->makeRequest('POST', 'authors', $params, $token);
    }

    /**
     * Retrive Single Droplet
     * 
     * @param int $id
     */
    public function getAuthorById($id, $token)
    {
        return $this->makeRequest('GET', 'authors/' . $id, [], $token);
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
