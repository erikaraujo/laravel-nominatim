<?php

namespace ErikAraujo\Nominatim;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Nominatim
{
    private string $url;

    /** @var array<string|int> */
    private array $params;

    private const STATUS_ENDPOINT = 'status.php';
    private const SEARCH_ENDPOINT = 'search?';
    private const REVERSE_ENDPOINT = 'reverse?';
    private const LOOKUP_ENDPOINT = 'lookup?';
    private const DETAILS_ENDPOINT = 'details?';
    private const ACCEPTED_POLYGON_TYPES = ['geojson', 'kml', 'svg', 'text'];

    public function __construct()
    {
        $this->url = strval(config('nominatim.url'));
        $this->params = [
            'format' => strval(config('nominatim.format')),
            'addressdetails' => intval(config('nominatim.details.include_address_details')),
            'extratags' => intval(config('nominatim.details.include_extra_tags')),
            'namedetails' => intval(config('nominatim.details.include_name_details')),
        ];

        if ((config('nominatim.polygon.include_polygon') && in_array(config('nominatim.polygon.polygon_type'), self::ACCEPTED_POLYGON_TYPES))) {
            $this->params['polygon_' . config('nominatim.polygon.polygon_type')] = (int) true;
        }

        if (config('nominatim.email.include_email')) {
            if (config('nominatim.email.include_email_type') === 'default') {
                $this->params['email'] = strval(config('nominatim.email.default_email'));
            }

            if (config('nominatim.email.include_email_type') === 'auth') {
                /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
                $user = auth()->user();
                $emailField = strval(config('nominatim.email.auth_email_field'));

                $this->params['email'] = $user->$emailField;
            }
        }
    }

    public function status(): Response
    {
        return Http::get($this->url . self::STATUS_ENDPOINT);
    }

    public function search(
        string $query = null,
        string $street = null,
        string $city = null,
        string $state = null,
        string $country = null,
        string $postalCode = null
    ): Response {
        $url = $this->url . self::SEARCH_ENDPOINT;
        $params = array_merge(
            $this->params,
            [
                'q' => $query,
                'street' => $street,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'postalcode' => $postalCode,
            ]
        );

        return Http::get($url, $params);
    }

    public function reverse(string $lat, string $lon): Response
    {
        $url = $this->url . self::REVERSE_ENDPOINT;
        $params = array_merge(
            $this->params,
            [
                'lat' => $lat,
                'lon' => $lon,
            ]
        );

        return Http::get($url, $params);
    }

    public function lookup(string $osmIds): Response
    {
        $url = $this->url . self::LOOKUP_ENDPOINT;
        $params = array_merge(
            $this->params,
            [
                'osm_ids' => $osmIds,
            ]
        );

        return Http::get($url, $params);
    }

    public function details(string $osmType, string $osmId, string $category = null): Response
    {
        $url = $this->url . self::DETAILS_ENDPOINT;
        $params = array_merge(
            $this->params,
            [
                'osmtype' => $osmType,
                'osmid' => $osmId,
                'class' => $category,
            ]
        );

        return Http::get($url, $params);
    }

    public function withAddressDetails(): self
    {
        $this->params['addressdetails'] = (int) true;

        return $this;
    }

    public function withoutAddressDetails(): self
    {
        $this->params['addressdetails'] = (int) false;

        return $this;
    }

    public function withExtraTags(): self
    {
        $this->params['extratags'] = (int) true;

        return $this;
    }

    public function withoutExtraTags(): self
    {
        $this->params['extratags'] = (int) false;

        return $this;
    }

    public function withNameDetails(): self
    {
        $this->params['namedetails'] = (int) true;

        return $this;
    }

    public function withoutNameDetails(): self
    {
        $this->params['namedetails'] = (int) false;

        return $this;
    }

    /**
     * @param array<int> $ids
     */
    public function excludePlaceIds(array $ids): self
    {
        $this->params['exclude_place_ids'] = implode(',', $ids);

        return $this;
    }

    /**
     * @param array<string> $countries
     */
    public function forCountries(array $countries): self
    {
        $this->params['countrycodes'] = implode(',', $countries);

        return $this;
    }

    public function withLimitedResults(int $limit): self
    {
        if ($limit > 0) {
            $this->params['limit'] = $limit;
        }

        return $this;
    }

    public function withEmail(string $email): self
    {
        $this->params['email'] = $email;

        return $this;
    }

    public function withoutEmail(): self
    {
        unset($this->params['email']);

        return $this;
    }

    public function withPolygon(string $polygon): void
    {
        if (! empty($polygon) && in_array($polygon, self::ACCEPTED_POLYGON_TYPES)) {
            $this->params['polygon_' . $polygon] = (int) true;
        }
    }

    public function withoutPolygon(): self
    {
        foreach (self::ACCEPTED_POLYGON_TYPES as $polygonType) {
            $this->params['polygon_' . $polygonType] = (int) false;
        }

        return $this;
    }

    public function debug(): self
    {
        $this->params['debug'] = (int) true;

        return $this;
    }
}
