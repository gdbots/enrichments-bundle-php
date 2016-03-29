<?php

namespace Gdbots\Tests\Bundle\EnrichmentsBundle\Fixtures;

use Gdbots\Pbj\AbstractMessage;
use Gdbots\Pbj\MessageResolver;
use Gdbots\Pbj\Schema;
use Gdbots\Pbj\Type as T;
use Gdbots\Schemas\Enrichments\TimeParting\TimePartingV1;
use Gdbots\Schemas\Enrichments\TimeParting\TimePartingV1Mixin;
use Gdbots\Schemas\Enrichments\TimeParting\TimePartingV1Trait;
use Gdbots\Schemas\Enrichments\TimeSampling\TimeSamplingV1;
use Gdbots\Schemas\Enrichments\TimeSampling\TimeSamplingV1Mixin;
use Gdbots\Schemas\Enrichments\TimeSampling\TimeSamplingV1Trait;
use Gdbots\Schemas\Enrichments\UaParser\UaParserV1;
use Gdbots\Schemas\Enrichments\UaParser\UaParserV1Mixin;
use Gdbots\Schemas\Enrichments\UaParser\UaParserV1Trait;
use Gdbots\Schemas\Pbjx\Command\CommandV1;
use Gdbots\Schemas\Pbjx\Command\CommandV1Mixin;
use Gdbots\Schemas\Pbjx\Command\CommandV1Trait;

final class FakeCommand extends AbstractMessage implements
    CommandV1,
    TimePartingV1,
    TimeSamplingV1,
    UaParserV1
{
    use CommandV1Trait;
    use TimePartingV1Trait;
    use TimeSamplingV1Trait;
    use UaParserV1Trait;

    /**
     * @return Schema
     */
    protected static function defineSchema()
    {
        $schema = new Schema('pbj:gdbots:tests.enrichments:fixtures:fake-command:1-0-0', __CLASS__, [],
            [
                CommandV1Mixin::create(),
                TimePartingV1Mixin::create(),
                TimeSamplingV1Mixin::create(),
                UaParserV1Mixin::create(),
            ]
        );

        MessageResolver::registerSchema($schema);
        return $schema;
    }
}
