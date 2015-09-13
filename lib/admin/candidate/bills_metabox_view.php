<table class="candidate_bill_voting_history">
  <thead>
    <tr>
      <th>Bill</th>
      <th>Issue</th>
      <th>Vote</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($bills as $bill): ?>
    <tr>
      <td><?php echo $bill->getTitle(); ?></td>
      <td><?php echo $bill->getIssueTitle(); ?></td>
      <td>
        <select name="bill[<?php echo $bill->getID(); ?>]">
          <option
            value="1"
            <?php if (!empty($votingHistory) && $votingHistory[$bill->getID()] == true): ?>selected<?php endif; ?>
            >Voted For</option>
          <option
            value="0"
            <?php if (!empty($votingHistory) && $votingHistory[$bill->getID()] == false): ?>selected<?php endif; ?>
            >Voted Against</option>
        </select>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<input type="hidden" name="candidate_bill_nonce" value="<?php echo wp_create_nonce('candidate_bill_nonce'); ?>" />

<style type="text/css">
.candidate_bill_voting_history { width: 100%; }
.candidate_bill_voting_history td { text-align: center; }
</style>
