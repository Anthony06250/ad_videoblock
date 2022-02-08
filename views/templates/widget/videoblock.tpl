<section id="ad-videoblock">
    {foreach from=$videoblocks item=videoblock}
        {if !empty($videoblock.block_title) or !empty($videoblock.block_title)}
            <header class="ad-vb-title">
                {if !empty($videoblock.block_title)}
                    <h2>{$videoblock.block_title}</h2>
                {/if}
                {if !empty($videoblock.block_subtitle)}
                    <p>{$videoblock.block_subtitle}</p>
                {/if}
            </header>
        {/if}
        <section class="ad-vb-content">
            <article class="container">
                <figure class="ad-vb-videobox">
                    <iframe class="ad-vb-video" src="{$videoblock.video_path}"
                            title="{$videoblock.video_title}"
                            allow="{$videoblock.video_options}"
                            {if $videoblock.video_fullscreen === 1}allowfullscreen{/if}>
                    </iframe>
                </figure>
            </article>
        </section>
    {/foreach}
</section>
