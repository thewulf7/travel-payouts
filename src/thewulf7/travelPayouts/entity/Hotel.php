<?php
/**
 * travelPayouts.Hotel.php
 * User: johnnyutkin
 * Date: 11/06/2017
 * Time: 12:46
 */

namespace thewulf7\travelPayouts\entity;


/**
 * Class Hotel
 *
 * @package thewulf7\travelPayouts\entity
 */
class Hotel
{
    /**
     * @var int
     */
    private $_id;

    /**
     * @var int
     */
    private $_cityId;

    /**
     * @var int
     */
    private $_stars;

    /**
     * @var float
     */
    private $_priceFrom;

    /**
     * @var float
     */
    private $_rating;

    /**
     * @var string
     */
    private $_popularity;

    /**
     * @var string
     */
    private $_propertyType;

    /**
     * @var string
     */
    private $_checkOut;

    /**
     * @var string
     */
    private $_checkIn;

    /**
     * @var float
     */
    private $_distance;

    /**
     * @var int
     */
    private $_photoCount;

    /**
     * @var array
     */
    private $_photos;

    /**
     * @var array
     */
    private $_facilities;

    /**
     * @var array
     */
    private $_shortFacilities;

    /**
     * @var array
     */
    private $_photosByRoomType;

    /**
     * @var array
     */
    private $_location;

    /**
     * @var string
     */
    private $_name;

    /**
     * @var string
     */
    private $_address;

    /**
     * @var string
     */
    private $_link;

    /**
     * @var int
     */
    private $_poiDistance;

    /**
     * @var array
     */
    private $_pois;

    /**
     * Get Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set id
     *
     * @param int $id
     *
     * @return Hotel
     */
    public function setId($id)
    {
        $this->_id = $id;

        return $this;
    }

    /**
     * Get CityId
     *
     * @return int
     */
    public function getCityId()
    {
        return $this->_cityId;
    }

    /**
     * Set cityId
     *
     * @param int $cityId
     *
     * @return Hotel
     */
    public function setCityId($cityId)
    {
        $this->_cityId = $cityId;

        return $this;
    }

    /**
     * Get Stars
     *
     * @return int
     */
    public function getStars()
    {
        return $this->_stars;
    }

    /**
     * Set stars
     *
     * @param int $stars
     *
     * @return Hotel
     */
    public function setStars($stars)
    {
        $this->_stars = $stars;

        return $this;
    }

    /**
     * Get PriceFrom
     *
     * @return float
     */
    public function getPriceFrom()
    {
        return $this->_priceFrom;
    }

    /**
     * Set priceFrom
     *
     * @param float $priceFrom
     *
     * @return Hotel
     */
    public function setPriceFrom($priceFrom)
    {
        $this->_priceFrom = $priceFrom;

        return $this;
    }

    /**
     * Get Rating
     *
     * @return float
     */
    public function getRating()
    {
        return $this->_rating;
    }

    /**
     * Set rating
     *
     * @param float $rating
     *
     * @return Hotel
     */
    public function setRating($rating)
    {
        $this->_rating = $rating;

        return $this;
    }

    /**
     * Get Popularity
     *
     * @return string
     */
    public function getPopularity()
    {
        return $this->_popularity;
    }

    /**
     * Set popularity
     *
     * @param string $popularity
     *
     * @return Hotel
     */
    public function setPopularity($popularity)
    {
        $this->_popularity = $popularity;

        return $this;
    }

    /**
     * Get PropertyType
     *
     * @return string
     */
    public function getPropertyType()
    {
        return $this->_propertyType;
    }

    /**
     * Set propertyType
     *
     * @param string $propertyType
     *
     * @return Hotel
     */
    public function setPropertyType($propertyType)
    {
        $this->_propertyType = $propertyType;

        return $this;
    }

    /**
     * Get CheckOut
     *
     * @return string
     */
    public function getCheckOut()
    {
        return $this->_checkOut;
    }

    /**
     * Set checkOut
     *
     * @param string $checkOut
     *
     * @return Hotel
     */
    public function setCheckOut($checkOut)
    {
        $this->_checkOut = $checkOut;

        return $this;
    }

    /**
     * Get CheckIn
     *
     * @return string
     */
    public function getCheckIn()
    {
        return $this->_checkIn;
    }

    /**
     * Set checkIn
     *
     * @param string $checkIn
     *
     * @return Hotel
     */
    public function setCheckIn($checkIn)
    {
        $this->_checkIn = $checkIn;

        return $this;
    }

    /**
     * Get Distance
     *
     * @return float
     */
    public function getDistance()
    {
        return $this->_distance;
    }

    /**
     * Set distance
     *
     * @param float $distance
     *
     * @return Hotel
     */
    public function setDistance($distance)
    {
        $this->_distance = $distance;

        return $this;
    }

    /**
     * Get PhotoCount
     *
     * @return int
     */
    public function getPhotoCount()
    {
        return $this->_photoCount;
    }

    /**
     * Set photoCount
     *
     * @param int $photoCount
     *
     * @return Hotel
     */
    public function setPhotoCount($photoCount)
    {
        $this->_photoCount = $photoCount;

        return $this;
    }

    /**
     * Get Photos
     *
     * @return array
     */
    public function getPhotos()
    {
        return $this->_photos;
    }

    /**
     * Set photos
     *
     * @param array $photos
     *
     * @return Hotel
     */
    public function setPhotos($photos)
    {
        $this->_photos = $photos;

        return $this;
    }

    /**
     * Get Facilities
     *
     * @return array
     */
    public function getFacilities()
    {
        return $this->_facilities;
    }

    /**
     * Set facilities
     *
     * @param array $facilities
     *
     * @return Hotel
     */
    public function setFacilities($facilities)
    {
        $this->_facilities = $facilities;

        return $this;
    }

    /**
     * Get ShortFacilities
     *
     * @return array
     */
    public function getShortFacilities()
    {
        return $this->_shortFacilities;
    }

    /**
     * Set shortFacilities
     *
     * @param array $shortFacilities
     *
     * @return Hotel
     */
    public function setShortFacilities($shortFacilities)
    {
        $this->_shortFacilities = $shortFacilities;

        return $this;
    }

    /**
     * Get PhotosByRoomType
     *
     * @return array
     */
    public function getPhotosByRoomType()
    {
        return $this->_photosByRoomType;
    }

    /**
     * Set photosByRoomType
     *
     * @param array $photosByRoomType
     *
     * @return Hotel
     */
    public function setPhotosByRoomType($photosByRoomType)
    {
        $this->_photosByRoomType = $photosByRoomType;

        return $this;
    }

    /**
     * Get Location
     *
     * @return array
     */
    public function getLocation()
    {
        return $this->_location;
    }

    /**
     * Set location
     *
     * @param array $location
     *
     * @return Hotel
     */
    public function setLocation($location)
    {
        $this->_location = $location;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Hotel
     */
    public function setName($name)
    {
        $this->_name = $name;

        return $this;
    }

    /**
     * Get Address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Hotel
     */
    public function setAddress($address)
    {
        $this->_address = $address;

        return $this;
    }

    /**
     * Get Link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->_link;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Hotel
     */
    public function setLink($link)
    {
        $this->_link = $link;

        return $this;
    }

    /**
     * Get PoiDistance
     *
     * @return int
     */
    public function getPoiDistance()
    {
        return $this->_poiDistance;
    }

    /**
     * Set poiDistance
     *
     * @param int $poiDistance
     *
     * @return Hotel
     */
    public function setPoiDistance($poiDistance)
    {
        $this->_poiDistance = $poiDistance;

        return $this;
    }

    /**
     * Get Pois
     *
     * @return array
     */
    public function getPois()
    {
        return $this->_pois;
    }

    /**
     * Set pois
     *
     * @param array $pois
     *
     * @return Hotel
     */
    public function setPois($pois)
    {
        $this->_pois = $pois;

        return $this;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes($attributes = [])
    {
        foreach ($attributes as $attribute => $value) {

            $funcName = 'set' . ucfirst($attribute);

            if (method_exists($this, $funcName)) {
                $this->$funcName($value);
            }
        }
    }
}