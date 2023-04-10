<select name="Bank_id" id="Bank_id" style="width:163px;" required>
                                            <option value="">Select Bank</option>
                                <?php $sql = mysql_query("SELECT * FROM tbl_Bank");
                                while($row = mysql_fetch_array($sql)){ ?>
                                <option value="<?php echo $row['Bank_SiNo'] ?>"><?php echo $row['Bank_name'] ?></option>
                                <?php } ?>                                     
                                        </select>