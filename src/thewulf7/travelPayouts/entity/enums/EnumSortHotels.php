<?php
/**
 * travelPayouts.EnumSortHotels.php
 * User: johnnyutkin
 * Date: 11/06/2017
 * Time: 14:08
 */

namespace thewulf7\travelPayouts\entity\enums;


interface EnumSortHotels
{
    const POPULARITY = 'popularity';

    const PRICE = 'price';

    const NAME = 'name';

    const GUEST_SCORE = 'guestScore';

    const STARS = 'stars';
}