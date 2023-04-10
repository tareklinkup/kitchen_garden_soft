<select id="country">
                                        <option value="">Select Country</option>
                                        <?php
                            $q_country=mysql_query("SELECT * FROM `tbl_country`") ;
                            while ($row=mysql_fetch_array($q_country)) {
                                           
                                    ?>
                                    <option value="<?php echo $row['Country_SlNo']; ?>"><?php echo $row['CountryName']; ?></option>
                                <?php } ?>
                                    </select>