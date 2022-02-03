<div class="card subscription-plan" data-modal="subscription-plan-modal">
  <div class="card-section">
    <h3>Subscription Plan</h3>
    <div class="info">
      <ul>
        <li><strong>Plan</strong> <?php echo "{$plan}"; ?></li>
        <li><strong>Remaining Runs</strong> <?php echo "{$remaining}"; ?></li>
        <li><strong>Runs Renewal</strong> <?php echo "{$run_renewal}"; ?></li>
        <li><strong>Price</strong> <?php echo "{$price}"; ?></li>
        <li><strong>Payment</strong> <?php echo "{$payment_frequency}"; ?></li>
        <li><strong>Plan Renewal</strong> <?php echo "{$plan_renewal}"; ?></li>
        <li><strong>Status</strong> <?php echo "{$status}"; ?></li>
      </ul>
    </div>
  </div>
  <div class="card-section">
    <div class="edit-button">
      <button><span>Edit</span></button>
    </div>
  </div>
</div>

<div class="card payment-info" data-modal="payment-info-modal">
  <div class="card-section">
    <div class="info">
      <div class="cc-type">
        <img src="/foo.jpg" alt="card-type" width="80px" height="54px" />
      </div>
      <div class="cc-details">
        <div class="cc-number"><?php echo "{$cc_number}"; ?></div>
        <div class="cc-expiration">Expires: <?php echo "{$cc_expiration_date}"; ?></div>
      </div>
    </div>
  </div>
  <div class="card-section">
    <div class="edit-button">
      <button><span>Edit</span></button>
    </div>
  </div>
</div>

<div class="card billing-history">
  <h3>Billing History</h3>
  <div class="info">
    <table>
      <thead>
        <tr>
          <th>Date Time Stamp</th>
          <th>Credit Card</th>
          <th>Card Number</th>
          <th>Amount</th>
        </tr>
      </thead>
      <tbody>
<?php foreach($billing_history as $row) {
  echo "<tr>
          <td>{$row['date_time_stamp']}</td>
          <td>{$row['credit_card']}</td>
          <td>{$row['cc_number']}</td>
          <td>{$row['amount']}</td>
        </tr>";
} ?>
      </tbody>
    </table>
  </div>
</div>

<div class="card api-consumers">
  <h3>API Consumers</div>
  <div class="info">
  </div>
</div>
</div>
