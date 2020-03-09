<?php
namespace Mageplaza\Giftcard\Api;

interface GiftcardValidInterface
{
    /**
     * Returns whether a giftcard exists or not
     * @param string $giftcode
     * @api
     * @return string
     */

    public function isValid($giftcode);
}