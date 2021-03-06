<?php
declare(strict_types=1);

namespace Gdbots\Tests\Bundle\EnrichmentsBundle;

use Gdbots\Bundle\EnrichmentsBundle\TimeSamplingEnricher;
use Gdbots\Pbj\WellKnown\Microtime;
use Gdbots\Pbjx\Event\PbjxEvent;
use PHPUnit\Framework\TestCase;

class TimeSamplingEnricherTest extends TestCase
{
    public function testEnrich()
    {
        $command = Fixtures\FakeCommand::create();
        $command->set('occurred_at', Microtime::fromFloat((new \DateTime('2015-12-25T01:15:30.123456Z'))->format('U.u')));
        $enricher = new TimeSamplingEnricher();
        $pbjxEvent = new PbjxEvent($command);

        $enricher->enrich($pbjxEvent);

        $this->assertSame(2015122501, $command->get('ts_ymdh'));
        $this->assertSame(20151225, $command->get('ts_ymd'));
        $this->assertSame(201512, $command->get('ts_ym'));
    }
}
