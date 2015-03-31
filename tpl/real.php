<?php
switch (get_locale()) {
  case 'ru_RU':
    $lng = array(
      'Благотворительность',
      'Буду безмерно благодарен за любую поддержку!',
      'Donate'
    );
    break;

  default:
    $lng = array(
      'Donation',
      'I would be very grateful for any support!',
      'Donate'
    );
    break;
}
?>

<style>
  .donate {
    display: inline-block;
    padding: 10px 30px;
    text-decoration: none;
    background: #88DBF7;
    border: 1px solid silver;
    -webkit-border-radius: 5px;
       -moz-border-radius: 5px;
            border-radius: 5px;
  }
</style>
<h1><?= $lng[0]; ?></h1>
<p><?= $lng[1]; ?></p>
<a target="_blank" href="https://funding.webmoney.ru/realplugins-for-wordpress/donate" class="button button-primary">
  <?= $lng[2]; ?>
</a>