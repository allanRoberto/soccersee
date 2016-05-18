
<!-- The details of a specific product for editing, based on the product ID -->
		
		<?php $Field = $wpdb->get_row($wpdb->prepare("SELECT * FROM $ewd_feup_fields_table_name WHERE Field_ID ='%d'", $_GET['Field_ID'])); ?>
		
		<div class="OptionTab ActiveTab" id="EditField">
				<div class="form-wrap EditField">
						<a href="admin.php?page=EWD-FEUP-options&DisplayPage=Field" class="NoUnderline">&#171; <?php _e("Back", 'EWD_FEUP') ?></a>
						<h3>Edit <?php echo $Field->Field_Name;?></h3>
						<form id="addtag" method="post" action="admin.php?page=EWD-FEUP-options&Action=EWD_FEUP_EditField&DisplayPage=Field" class="validate" enctype="multipart/form-data">
								<input type="hidden" name="action" value="Edit_Field" />
								<?php wp_nonce_field(); ?>
								<?php wp_referer_field(); ?>
								<input type='hidden' name='Field_ID' value='<?php echo $Field->Field_ID; ?>'>
								<div class="form-field form-required">
										<label for="Field_Name"><?php _e("Name", 'EWD_FEUP') ?></label>
										<input name="Field_Name" class='ewd-admin-regular-text' id="Field_Name" type="text" value="<?php echo $Field->Field_Name; ?>" size="60" />
										<p><?php _e("The name of the field your users will see.", 'EWD_FEUP') ?></p>
								</div>
								<div class="form-field">
										<label for="Field_Type"><?php _e("Type", 'EWD_FEUP') ?></label>
										<select name="Field_Type" id="Field_Type">
												<option value='text' <?php if ($Field->Field_Type == 'text') {echo "selected='selected'";} ?>>Short Text</option>
												<option value='mediumint' <?php if ($Field->Field_Type == 'mediumint') {echo "selected='selected'";} ?>>Integer</option>
												<option value='picture' <?php if ($Field->Field_Type == 'picture') {echo "selected='selected'";} ?>>Profile Picture</option>
												<option value='select' <?php if ($Field->Field_Type == 'select') {echo "selected='selected'";} ?>>Select Box</option>
												<option value='radio' <?php if ($Field->Field_Type == 'radio') {echo "selected='selected'";} ?>>Radio Button</option>
												<option value='checkbox' <?php if ($Field->Field_Type == 'checkbox') {echo "selected='selected'";} ?>>Checkbox</option>
												<option value='textarea' <?php if ($Field->Field_Type == 'textarea') {echo "selected='selected'";} ?>>Text Area</option>
												<option value='file' <?php if ($Field->Field_Type == 'file') {echo "selected='selected'";} ?>>File</option>
												<option value='date' <?php if ($Field->Field_Type == 'date') {echo "selected='selected'";} ?>>Date</option>
												<option value='datetime' <?php if ($Field->Field_Type == 'datetime') {echo "selected='selected'";} ?>>Date/Time</option>
												<option value='countries' <?php if ($Field->Field_Type == 'countries') {echo "selected='selected'";} ?>>Country Select</option>
										</select>
										<p><?php _e("The input method for the field and type of data that the field will hold.", 'EWD_FEUP') ?></p>
								</div>
								<div class="form-field">
										<label for="Field_Description"><?php _e("Description", 'EWD_FEUP') ?></label>
										<textarea name="Field_Description" class='ewd-admin-large-text' id="Field_Description" rows="2" cols="40"><?php echo $Field->Field_Description; ?></textarea>
										<p><?php _e("The description of the field, which the user will see as the instruction for the field.", 'EWD_FEUP') ?></p>
								</div>
								<div>
										<label for="Field_Options"><?php _e("Input Values", 'EWD_FEUP') ?></label>
										<input name="Field_Options" class='ewd-admin-regular-text' id="Field_Options" type="text" value="<?php echo $Field->Field_Options; ?>" size="60" />
										<p><?php _e("A comma-separated list of acceptable input values for this field. These values will be the options for select, checkbox, and radio inputs. All values will be accepted if left blank.", 'EWD_FEUP') ?></p>
								</div>
								<div>
										<label for="Field_Show_In_Admin"><?php _e("Show in Admin Table?", 'EWD_FEUP') ?></label>
										<input type='radio' name="Field_Show_In_Admin" value="Yes" <?php if ($Field->Field_Show_In_Admin == "Yes") {echo "checked";} ?>>Yes<br/>
										<input type='radio' name="Field_Show_In_Admin" value="No" <?php if ($Field->Field_Show_In_Admin == "No") {echo "checked";} ?>>No<br/>
										<p><?php _e("Should this field appear in the users table in the admin area?", 'EWD_FEUP') ?></p>
								</div>
								<div>
										<label for="Field_Show_In_Front_End"><?php _e("Show in User Profile", 'EWD_FEUP') ?></label>
										<input type='radio' name="Field_Show_In_Front_End" value="Yes" <?php if ($Field->Field_Show_In_Front_End == "Yes") {echo "checked";} ?>>Yes<br/>
										<input type='radio' name="Field_Show_In_Front_End" value="No" <?php if ($Field->Field_Show_In_Front_End == "No") {echo "checked";} ?>>No<br/>
										<p><?php _e("Should this field appear in users' profiles in the front-end?", 'EWD_FEUP') ?></p>
								</div>
								<div>
										<label for="Field_Required"><?php _e("Required?", 'EWD_FEUP') ?></label>
										<input type='radio' name="Field_Required" value="Yes" <?php if ($Field->Field_Required == "Yes") {echo "checked";} ?>>Yes<br/>
										<input type='radio' name="Field_Required" value="No" <?php if ($Field->Field_Required == "No") {echo "checked";} ?>>No<br/>
										<p><?php _e("Area users required to fill out this field?", 'EWD_FEUP') ?></p>
								</div>

								<div class="form-field">
									<label for="Field_Equivalent"><?php _e("Field Meaning", 'EWD_FEUP') ?></label>
									<select name="Field_Equivalent" id="Field_Equivalent">
											<option value='None' <?php if ($Field->Field_Equivalent == 'None') {echo "selected='selected'";} ?>>None</option>
											<option value='First_Name' <?php if ($Field->Field_Equivalent == 'First_Name') {echo "selected='selected'";} ?>>First Name</option>
											<option value='Last_Name' <?php if ($Field->Field_Equivalent == 'Last_Name') {echo "selected='selected'";} ?>>Last Name</option>
											<?php if ($Username_Is_Email == "No") { ?><option value='Email' <?php if ($Field->Field_Equivalent == 'Email') {echo "selected='selected'";} ?>>Email</option><?php } ?>
											<option value='Phone'<?php if ($Field->Field_Equivalent == 'Phone') {echo "selected='selected'";} ?>>Phone</option>
											<option value='Address' <?php if ($Field->Field_Equivalent == 'Address') {echo "selected='selected'";} ?>>Address</option>
											<option value='City' <?php if ($Field->Field_Equivalent == 'City') {echo "selected='selected'";} ?>>City</option>
											<option value='Province' <?php if ($Field->Field_Equivalent == 'Province') {echo "selected='selected'";} ?>>Province</option>
											<option value='Country' <?php if ($Field->Field_Equivalent == 'Country') {echo "selected='selected'";} ?>>Country</option>
											<option value='Postal_Code' <?php if ($Field->Field_Equivalent == 'Postal_Code') {echo "selected='selected'";} ?>>Postal Code</option>
									</select>
									<p><?php _e("The meaning of the field. This field is only necessary if WordPress users are being created using the plugin, or if data is being pulled from Facebook.", 'EWD_FEUP') ?></p>
								</div>

								<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Edit Field', 'EWD_FEUP') ?>"  /></p></form>

				</div>
		</div>	