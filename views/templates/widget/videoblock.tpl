{if !empty($videoblocks)}
    <section id="ad-videoblock">
        {foreach from=$videoblocks item=videoblock}
            {if !empty($videoblock.title) or !empty($videoblock.subtitle)}
                <header class="ad-vb-title">
                    {if !empty($videoblock.title)}
                        <h2>{$videoblock.title}</h2>
                    {/if}
                    {if !empty($videoblock.subtitle)}
                        <p>{$videoblock.subtitle}</p>
                    {/if}
                </header>
            {/if}
            <section class="ad-vb-content">
                <article class="container">
                    <figure class="ad-vb-videobox">
                        <iframe class="ad-vb-video"
                            src="{$videoblock.url}"
                            title="{$videoblock.description}"
                            allow="{$videoblock.options}"
                            {if $videoblock.fullscreen === '1'}allowfullscreen{/if}>
                        </iframe>
                    </figure>
                </article>
            </section>
        {/foreach}
    </section>
{/if}
