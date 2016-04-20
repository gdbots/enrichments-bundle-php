<?php

namespace Gdbots\Bundle\EnrichmentsBundle;

use Gdbots\Common\Microtime;
use Gdbots\Pbjx\Event\PbjxEvent;
use Gdbots\Pbjx\EventSubscriber;
use Gdbots\Schemas\Common\Enum\DayOfWeek;
use Gdbots\Schemas\Common\Enum\Month;
use Gdbots\Schemas\Enrichments\Mixin\TimeParting\TimeParting;

class TimePartingEnricher implements EventSubscriber
{
    /**
     * @param PbjxEvent $event
     */
    public function enrich(PbjxEvent $event)
    {
        /** @var TimeParting $message */
        $message = $event->getMessage();
        $date = $message->get('occurred_at');

        if ($date instanceof Microtime) {
            $date = $date->toDateTime();
        }

        if (!$date instanceof \DateTime) {
            // no "occurred_at" field to pull from.
            return;
        }

        $dayOfWeek = (int)$date->format('w');
        $message
            ->set('month_of_year', Month::create((int)$date->format('n')))
            ->set('day_of_month', (int)$date->format('j'))
            ->set('day_of_week', DayOfWeek::create($dayOfWeek))
            ->set(
                'is_weekend',
                $dayOfWeek === DayOfWeek::SUNDAY
                || $dayOfWeek === DayOfWeek::SATURDAY
                || $dayOfWeek === DayOfWeek::SUNDAY_TOO
            )
            ->set('hour_of_day', (int)$date->format('G'))
        ;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'gdbots:enrichments:mixin:time-parting.enrich' => 'enrich',
        ];
    }
}
