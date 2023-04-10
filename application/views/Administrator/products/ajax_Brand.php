<select id="brand">
                                        <option value="">Select Brand</option>
                                       <?php
                            $q_country=mysql_query("SELECT * FROM `tbl_brand`") ;
                            while ($row=mysql_fetch_array($q_country)) {
                                           
                                    ?>
                                        <option value="<?php echo $row['brand_SiNo']; ?>"><?php echo $row['brand_name']; ?></option>
                                <?php } ?>
                                    </select>