<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Api
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */


namespace Twilio\Rest\Api\V2010\Account\Queue;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\Deserialize;


/**
 * @property string|null $callSid
 * @property \DateTime|null $dateEnqueued
 * @property int|null $position
 * @property string|null $uri
 * @property int|null $waitTime
 * @property string|null $queueSid
 */
class MemberInstance extends InstanceResource
{
    /**
     * Initialize the MemberInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $accountSid The SID of the [Account](https://www.twilio.com/docs/iam/api/account) that created the Member resource(s) to fetch.
     * @param string $queueSid The SID of the Queue in which to find the members to fetch.
     * @param string $callSid The [Call](https://www.twilio.com/docs/voice/api/call-resource) SID of the resource(s) to fetch.
     */
    public function __construct(Version $version, array $payload, string $accountSid, string $queueSid, string $callSid = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'callSid' => Values::array_get($payload, 'call_sid'),
            'dateEnqueued' => Deserialize::dateTime(Values::array_get($payload, 'date_enqueued')),
            'position' => Values::array_get($payload, 'position'),
            'uri' => Values::array_get($payload, 'uri'),
            'waitTime' => Values::array_get($payload, 'wait_time'),
            'queueSid' => Values::array_get($payload, 'queue_sid'),
        ];

        $this->solution = ['accountSid' => $accountSid, 'queueSid' => $queueSid, 'callSid' => $callSid ?: $this->properties['callSid'], ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return MemberContext Context for this MemberInstance
     */
    protected function proxy(): MemberContext
    {
        if (!$this->context) {
            $this->context = new MemberContext(
                $this->version,
                $this->solution['accountSid'],
                $this->solution['queueSid'],
                $this->solution['callSid']
            );
        }

        return $this->context;
    }

    /**
     * Fetch the MemberInstance
     *
     * @return MemberInstance Fetched MemberInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): MemberInstance
    {

        return $this->proxy()->fetch();
    }

    /**
     * Update the MemberInstance
     *
     * @param string $url The absolute URL of the Queue resource.
     * @param array|Options $options Optional Arguments
     * @return MemberInstance Updated MemberInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(string $url, array $options = []): MemberInstance
    {

        return $this->proxy()->update($url, $options);
    }

    /**
     * Magic getter to access properties
     *
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get(string $name)
    {
        if (\array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        if (\property_exists($this, '_' . $name)) {
            $method = 'get' . \ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException('Unknown property: ' . $name);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.MemberInstance ' . \implode(' ', $context) . ']';
    }
}
