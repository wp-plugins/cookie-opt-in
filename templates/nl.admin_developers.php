<div class='wrap'><?php print coia_donate_html(); ?>
  <h2>Cookie-Opt-In Informatie voor ontwikkelaars</h2>
  <div id="cookie">
    <p>Om je code aan te passen om de wensen van de bezoeker te respecteren moet je &eacute;&eacute;n van de volgende handelingen doen;</p>
    <p>(Let op; alleen van belang voor de delen van je code die cookies zetten! Zie '<a href="<?php print admin_url('admin.php?page=cookie-opt-in'); ?>">Informatie</a>').</p>
    <ol>
      <li>Maak de invoeging van script conditioneel. Hiervoor kun je de korte functie <code>coia</code> of het WordPress <code>filter</code> gebruiken;</li>
      <li><code>&lt;?php if (function_exists('coia') &amp;&amp; coia('tracking')) {
  // include google analytics
}?&gt;</code></li>
      <li><code>&lt;?php if (apply_filters('eu_cookie_consent', 'tracking') != 'denied') {
  // doe hier je ding
  //
}?&gt;</code>
      </li>
    </ol>
    <p>Geldige waarden zijn 'tracking', 'social', 'advertisement' en 'functional'. Het conditionaliseren van 'functional' is echter niet nuttig want deze cookies worden nooit geblokkeerd.</p>
    <p>( coia staat voor cookie-opt-in-accepted )</p>
    <p>Als alternatief kun je ons de add_action-aanroepen doorsturen welke de cookies-plaatsende-code invoegt, dan zorgen wij in de volgende update voor bijvoegen hiervan. (zie ook <a href="<?php print admin_url('admin.php?page=cookie-opt-in-actions'); ?>">Actie-lijst</a>)</p>
    <p>Voor de volgende typen cookies MOET je toestemming hebben;</p>
    <ol>
      <li>'tracking' ; Scripts en code welke gebruik maakt van cookies om gebruikers te volgen, zoals Google Analytics</li>
      <li>'advertisement' ; Scripts en code welke gebruik maakt van cookies om te bepalen welke advertenties te tonen, zoals Google Adwords</li>
      <li>'social' ; Scripts en code welke gebruik maakt van cookies om je sociale stappen te traceren, zoals Facebook en Google+</li>
    </ol>
    <p>Voor de volgende typen cookies heb je geen toestemming nodig maar moet je de bezoeker wel INFORMEREN;</p>
    <ol>
      <li>'functional' ; Een algemeen type cookie welke gebruikt wordt voor cookies die noodzakelijk zijn voor het correct functioneren van de site, zoals sessie-beheer.</li>
    </ol>
    <p>Deze plugin zal, zoals gezegd, de bezoeker informeren over de 'functional'-cookies maar staat niet toe ze te weigeren.</p>
    <h2>Notities</h2>
    <ol>
      <li>Een standaard WordPress site gebruikt GEEN cookies aan de voorkant, alleen in het CMS. Omdat CMS niet een publiek deel is valt dit buiten de wetgeving. Voor een out-of-the-box WordPress site heb je dus geen toestemming nodig.</li>
      <li>Wetten veranderen dagelijks en ook al doen we ons uiterste best om onszelf geinformeerd te houden kan het gebeuren dat we iets missen. We zijn slechts mensen. Contacteer ons a.u.b. als je iets tegenkomt dat niet klopt!</li>
    </ol>
    <h2>Hulp nodig?</h2>
    <p>We kunnen je helpen! Als je assistentie nodig hebt voor het aanpassen van je code, e-mail ons op <a href="mailto:support@clearsite.nl">support@clearsite.nl</a>. (Let wel: we geven geen garanties op response-tijden, maar we doen ons best.)</p>
  </div>
  <h2>Interface aanpassingen.</h2>
  <p>Met de volgende code kun je de plugin stylesheet en (interface)javascript blokkeren;</p>
  <code>
    add_filter('do_not_load_cookie_opt_in_visual_effects', 'my_plugin_of_theme_namespace_no_coia_visuals');
    function my_plugin_of_theme_namespace_no_coia_visuals() {
      return true;
    }
  </code>
  <p>Na deze code kun je de style geheel zelf bepalen en/of m.b.v. jQuery de DOM van de interface geheel naar wens aanpassen.</p>
  <p>In je javascript kun je methoden definieren in het cookie_opt_in object voor inhaken op de diverse processen;</p>
  <p>Voorbeeld:</p>
  <code>
    cookie_opt_in.hide_after = function () {
      // Een handeling die uitgevoerd wordt nadat de interface gesloten is.
    };
  </code>
  <p>De volgende 'hooks' zijn beschikbaar;</p>
  <table>
    <tr>
      <th>init_before, init_after</th><td>Uitgevoerd voordat/nadat de interface elements zijn gemaakt</td>
    </tr>
    <tr>
      <th>activate_before, activate_after</th><td>Uitgevoerd voordat/nadat events zijn gekoppeld aan de interface elementen (zoals bind('click') )</td>
    </tr>
    <tr>
      <th>action_before, action_after (*1)</th><td>Uitgevoerd voordat/nadat een button is geclicked (moet een <code>input</code> met class <code>button</code> zijn)</td>
    </tr>
    <tr>
      <th>show_before, show_after (*2)</th><td>Uitgevoerd voordat/nadat de interface is getoond</td>
    </tr>
    <tr>
      <th>hide_before, hide_after</th><td>Uitgevoerd voordat/nadat de interface is verborgen</td>
    </tr>
  </table>
  <p>Notes;</p>
  <ol>
    <li>Method krijgt parameter <code>this</code> mee</li>
    <li>Method krijgt parameter <code>boolean</code> mee, waarbij true zegt dat de cookie nieuw is (eerste bezoek)</li>
  </ol>
</div>