<?= render('include/static_header'); ?>

<h2 class="staticTitle">ヘルプ</h2>

<div class="helpContainer">

    <div class="helpContainer_title">プロジェクトについて</div>

    <div class="helpContainer_item">
        <dl class="helpContainer_list">
            <dt>このプロジェクトはどんなプロジェクトですか？</dt>
            <dd>自転車を中心とした道路交通上の危険箇所や過去の事故情報などを提供・情報共有を通じ、自転車の運行や、歩行者、車など交通参加者全体の安心、安全なまちづくりを目指した地図サービス</dd>
            <dt>誰でも参加できますか？</dt>
            <dd>現在は参加加盟大学を中心としたサービスですが、今後どなたでも情報の発信や投稿ができるように準備を進めています。情報の閲覧はどなたでも閲覧可能です。</dd>
        </dl>
    </div>

    <div class="helpContainer_title">地図について</div>
    <div class="helpContainer_item">
        <dl class="helpContainer_list">
            <dt>投稿は誰が行っているのですか？</dt>
            <dd>現在は、参加加盟大学のプロジェクトを中心に投稿を行っています。最終的にはどなたでも投稿できるようなシステムを目指しています。</dd>
            <dt>ピンの意味は？</dt>
            <dd>ピンの説明については<a href="<?= Uri::create('help/icon'); ?>">こちら</a>のページをご確認ください。</dd>
            <dt>Google Map 以外の地図でも閲覧できますか？</dt>
            <dd>はい、可能です。現在は以下の地図がご利用可能です。<br>
            ・Google Map<br>
            ・国土地理院地図<br>
            ・オープンストリートマップ
            </dd>
            <dt>過去の事故情報の根拠は？</dt>
            <dd>運営主体者である「全国大学生協共済生活協同組合連合会」が運営する「学生賠償責任保険」事業における、事故情報を元に情報を公開しています。</dd>
        </dl>
    </div>


    <div class="helpContainer_title">Webサイトについて</div>
    <div class="helpContainer_item">
        <dl class="helpContainer_list">
            <dt>利用可能なOS、ブラウザは何ですか？</dt>
            <dd>当サイトの閲覧は、スマートフォンの利用を前提として想定しています。スマートフォンからの閲覧推奨環境は以下の通りです。<br>
            iPhone：iOS8以降<br>
            Android：5.0以降
            </dd>
            <dt>パソコンからも閲覧できますか？</dt>
            <dd>基本的な表示については閲覧が可能ですが、一部のブラウザでは表示に不具合がでる可能性もあります。</dd>
        </dl>
    </div>


    <div class="helpContainer_title">個人情報について</div>
    <div class="helpContainer_item">
        <dl class="helpContainer_list">
            <dt>個人情報の取り扱いについて教えてください。</dt>
            <dd>当会の定める「個人情報保護方針」(<a href="http://kyosai.univcoop.or.jp/privacy/index.html" target="_blank">http://kyosai.univcoop.or.jp/privacy/index.html</a>)をご確認ください。</dd>
        </dl>
    </div>

    <div class="helpContainer_title">大学アカウントについて</div>
    <div class="helpContainer_item">
        <dl class="helpContainer_list">
            <dt>パスワードを忘れた場合はどうしたらいいですか？</dt>
            <dd>マイページよりパスワードの再発行が可能です。</dd>
            <dt>アカウントIDを忘れてしまった</dt>
            <dd>事務局までお問い合わせください。</dd>
        </dl>
    </div>

    <div class="helpContainer_title">サービスへのご要望・問合せについて</div>
    <div class="helpContainer_item">
        <dl class="helpContainer_list">
            <dt>このサイトについて問合せをしたいです。</dt>
            <dd><p>以下のメールアドレスにお問い合わせください。</p>
            <p><a href="mailto:info@bicyclesafetymap.jp">info@bicyclesafetymap.jp</a></p>
            <p>かならずしも全てのメールにご返信差し上げられない場合もございますので、予め御了承ください。</p>
            ※フリーメールからのお問い合わせについては、当会からのご返信が迷惑メール等に自動的に振り分けられる場合もございます。恐れいりますが、当社からのご返信が迷惑メールフォルダ等に入っていないかも、合わせてご確認ください。
            </dd>
        </dl>
    </div>

</div>
<!-- /.helpContainer -->


<?= render('include/static_footer'); ?>
