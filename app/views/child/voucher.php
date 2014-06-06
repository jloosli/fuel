<?php foreach($data as $datum): ?>
<table>
    <tr>
        <td class="ctr" colspan="6"><h2>Blair's Service Station GAS Coupon</h2></td>
    </tr>
    <tr>
        <td rowspan="3">QR Code Goes Here</td>
        <td colspan="1">Voucher #: 12345</td>
        <td colspan="1">Issued: <?php echo $datum['issued_date']; ?></td>
    </tr>
    <tr>


        <td class="ctr" colspan="5"><?php echo $datum['amount_text']; ?></td>
    </tr>
    <tr>

        <td>Recipient:</td>
        <td><?php echo $datum['issued_to']; ?></td>
    </tr>
    <tr>
        <td>Eccles Park Ward</td>
        <td>Bishop Loosli</td>
        <td class="signature" colspan="2">&nbsp;</td>
    </tr>
</table>
<?php endforeach;