<?php foreach($data as $datum): ?>
<table>
    <tr>
        <td class="ctr" colspan="3"><h2>Blair&CloseCurlyQuote;s Service Station GAS Coupon</h2></td>
        <td colspan="1" class="rt">Voucher #: <?php echo $datum['id']; ?></td>
    </tr>
    <tr>
        <td rowspan="2" class="qr"><?php echo $datum['qr']; ?></td>
        <td colspan="1">Recipient: <em><?php echo $datum['issued_to']; ?></em></td>
        <td class="ctr" colspan="2"><h3><?php echo $datum['amount_text']; ?></h3></td>
    </tr>
    <tr>

        <td class="lower">Eccles Park Ward<br>Issued: <?php echo $datum['issued_date']; ?></td>
        <td class="signature" colspan="3">Bishop Jared Loosli</td>
    </tr>
</table>
<?php endforeach;