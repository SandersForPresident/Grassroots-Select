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
        <select>
          <option>Voted For</option>
          <option>Voted Against</option>
        </select>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<style type="text/css">
.candidate_bill_voting_history { width: 100%; }
.candidate_bill_voting_history td { text-align: center; }
</style>
