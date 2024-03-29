<?php 

namespace Pronamic\Twinfield;

?>
<h2>Offices</h2>

<?php
	
$offices = $twinfieldClient->getOffices();

include 'table-offices.php';

?>

<h2>Sales invoice</h2>

<?php

$salesInvoice = $twinfieldClient->readSalesInvoice($office->getCode(), 'FACTUUR', '110082');

include 'sales-invoice.php';

?>

<h2>Transaction</h2>

<?php 

$transaction = $twinfieldClient->readTransaction($office->getCode(), 'VRK', '201100075');

include 'transaction.php';

?>

<h2>Finder</h2>

<?php 

$finder = $twinfieldClient->getFinder();

$search = new Search();
$search->setType(Search::TYPE_DIMENSION);
$search->setPattern('*');
$search->setField(Search::FIELD_ALL_CODE_OR_NAME);
$search->setFirstRow(1);
$search->setMaxRows(Search::ROWS_ALL);

$s1 = new ArrayOfString('section', 'financials');
$s2 = new ArrayOfString('dimtype', 'DEB');

$search->setOptions(array($s1, $s2));

$response = $finder->search($search);

$data = $response->getData();

?>
<table>
	<thead>
		<tr>

			<th>#<?php $i = 1; ?></th>

			<?php foreach($data->getColumns() as $column): ?>

			<th scope="col"><?php echo $column; ?></th>

			<?php endforeach; ?>

		</tr>
	</thead>

	<tbody>

		<?php foreach($data->getItems() as $item): ?>

		<tr>

			<td><?php echo $i++; ?></td>

			<?php foreach($item as $column): ?>

			<td><?php echo $column; ?></td>

			<?php endforeach; ?>

		</tr>

		<?php endforeach; ?>

	</tbody>
</table>

<h2>READ: dimension</h2>

<?php 

try {
	$result = $twinfieldClient->readDimension('dimensions', '11024', 'DEB', '1000');
} catch(\SoapFault $e) {
	echo '<pre>', $e->getTraceAsString(), '</pre>';
}

$debtor = $result;

?>
<h3>Debtor</h3>

<dl>
	
	<?php if($office = $debtor->getOffice()): ?>

	<dt>Office</dt>
	<dd>
		<dl>
			<dt>Code</dt>
			<dd><?php echo $office->getCode(); ?></dd>

			<dt>Name</dt>
			<dd><?php echo $office->getName(); ?></dd>

			<dt>Shortname</dt>
			<dd><?php echo $office->getShortName(); ?></dd>
		</dl>
	</dd>

	<?php endif; ?>

	<dt>Name</dt>
	<dd><?php echo $debtor->getName(); ?>

	<dt>Website</dt>
	<dd><?php echo $debtor->getWebsite(); ?>

	<dt>Addresses</dt>
	<dd>
		<ul>

			<?php foreach($debtor->getAddresses() as $address): ?>

			<li>
				<dl>
					<dt>Name</dt>
					<dd><?php echo $address->getName(); ?></dd>

					<dt>City</dt>
					<dd><?php echo $address->getCity(); ?></dd>

					<dt>Postcode</dt>
					<dd><?php echo $address->getPostcode(); ?></dd>

					<dt>Telephone</dt>
					<dd><?php echo $address->getTelephone(); ?></dd>

					<dt>Telefax</dt>
					<dd><?php echo $address->getTelefax(); ?></dd>

					<dt>E-mail</dt>
					<dd><?php echo $address->getEMail(); ?></dd>
				</dl>
			</li>

			<?php endforeach; ?>

		</ul>
	</dd>
</dl>