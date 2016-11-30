<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Takeit\Bundle\AmpHtmlBundle\Checker;

use PhpSpec\ObjectBehavior;
use Takeit\Bundle\AmpHtmlBundle\Checker\AmpSupportChecker;
use Takeit\Bundle\AmpHtmlBundle\Checker\AmpSupportCheckerInterface;

/**
 * @mixin AmpSupportChecker
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class AmpSupportCheckerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AmpSupportChecker::class);
        $this->shouldImplement(AmpSupportCheckerInterface::class);
    }

    function it_is_enabeld_by_default()
    {
        $this->isEnabled()->shouldReturn(true);
    }
}
