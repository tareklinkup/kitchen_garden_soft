     <select id="color">
                                        <option value="">Select Color</option>
                                        <?php
                            $q_country=mysql_query("SELECT * FROM `tbl_color`") ;
                            while ($row=mysql_fetch_array($q_country)) {
                                           
                                    ?>
                                        <option value="<?php echo $row['color_SiNo']; ?>"><?php echo $row['color_name']; ?></option>
                                <?php } ?>
                                    </select>       
    