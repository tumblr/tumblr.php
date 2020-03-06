<?php

namespace Tumblr\API\NPF\Content\Attribution;

use Tumblr\API\NPF\Content\Attribution\AttributionType;

/**
 * Class AttributionObject
 * An attribution is a reference to an external resource.
 * A provider can be another type of application or media type.
 * e.g.:
 * * Instagram image post
 * * Blog reference
 * @package Tumblr\API\NPF\Content\Attribution
 */
abstract class AttributionObject {
    /**
     * Type of attribution.
     * Used by the API to further process and embed the declared attribution.
     *
     * Supported and thus valid types of attribution are being provided in:
     *
     * Tumblr\API\NPF\Content\Attribution\AttributionTypes
     *
     * @var string
     */
    protected $type;

    /**
     * AttributionObject constructor.
     * @param string $type type of the provided attribution
     */
    protected function __construct(string $type) {
        $this->type = $type;
    }

    public function __get($property) {
        if(\property_exists($this, $property)) {
            return $this->$property;
        }
    }
}