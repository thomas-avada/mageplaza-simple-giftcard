<?php
namespace Mageplaza\Giftcard\Api;

interface HelloInterface
{
    /**
     * Returns greeting message to user
     *
     * @api
     * @param string $name Users name.
     * @return array
     */
    public function name($name);
}