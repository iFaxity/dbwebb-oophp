<?php

namespace Faxity\TextFilterer;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

/**
 * Text route for textfilter
 */
class TextFilterController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * Route for GET /textfilter
     * @return string.
     */
    public function indexActionGet()
    {
        $text = <<<EOF
Först lite vanlig text följt av en tom rad.

Då tar vi ett nytt stycke med lite bbcode med [b]bold[/b] och [i]italic[/i] samt en [url=https://dbwebb.se]Länk till dbwebb[/url].
Sen testar vi en länk till https://dbwebb.se som skall bli klickbar.
Efter det blir det en [länk skrivet i markdown](https://dbwebb.se) och länken leder till dbwebb.
Nu testar vi med en lista som formaterras till ul/li med markdown

* Item 1
* Item 2
* Item 3

<em>Denna meningen borde inte vara i en em tagg</em>
<strong>Denna meningen borde inte vara i en strong tagg och <code>denna i en kod tagg</code>.</strong>
Till sist provar vi om "citattecken" görs om till till &quot.
EOF;

        $filter = new TextFilter();
        $filters = [
            "strip",
            "esc",
            "bbcode",
            "markdown",
            "link",
            "nl2br",
        ];

        $this->app->page->add("textfilter/default", [
            "source" => $text,
            "formatted" => $filter->parse($text, $filters),
        ]);

        return $this->app->page->render([
            "title" => "TextFilter test",
        ]);
    }
}
