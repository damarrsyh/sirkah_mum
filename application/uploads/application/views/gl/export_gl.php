<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 12px;
  background: #fff;
  margin: 45px;
  border-collapse: collapse;
  text-align: left;
}
#hor-minimalist-b th
{
  font-size: 15px;
  font-weight: normal;
  color: #039;
  width: 190px;
  padding: 10px 8px;
  border-bottom: 2px solid #6678b1;
}
#hor-minimalist-b td
{
  border-bottom: 1px solid #ccc;
  color: #669;
  padding: 6px 8px;
}
#hor-minimalist-b tbody tr:hover td
{
  color: #009;
}


-->
</style>

<table id="hor-minimalist-b" summary="Employee Pay Sheet">
    <thead>
      <tr>
            <th scope="col">Account Code</th>
            <th scope="col">Account Name</th>
            <th scope="col">Account Type</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($account_group as $data):?>
      <tr>
            <td><?php echo $data['account_code'];?></td>
            <td><?php echo $data['account_name'];?></td>
            <td><?php echo $data['display_text'];?></td>
      </tr>
    <?php endforeach?>

    </tbody>
</table>