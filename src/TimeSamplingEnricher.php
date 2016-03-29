<?php

namespace Gdbots\Bundle\EnrichmentsBundle;

use Gdbots\Common\Microtime;
use Gdbots\Pbjx\Event\PbjxEvent;
use Gdbots\Pbjx\EventSubscriber;
use Gdbots\Schemas\Enrichments\TimeSampling\TimeSampling;

class TimeSamplingEnricher implements EventSubscriber
{
    /**
     * @param PbjxEvent $event
     */
    public function enrich(PbjxEvent $event)
    {
        /** @var TimeSampling $message */
        $message = $event->getMessage();
        $date = $message->get('occurred_at');

        if ($date instanceof Microtime) {
            $date = $date->toDateTime();
        }

        if (!$date instanceof \DateTime) {
            // no "occurred_at" field to pull from.
            return;
        }

        $message
            ->set('ts_ymdh', (int)$date->format('YmdH'))
            ->set('ts_ymd', (int)$date->format('Ymd'))
            ->set('ts_ym', (int)$date->format('Ym'))
        ;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'gdbots:enrichments:mixin:time-sampling.enrich' => 'enrich',
        ];
    }
}