<?php
/**
 + Created by	:	JoomBah Team
 * Company		:	ISDS Sdn Bhd
 + Contact		:	www.joombah.com , support@joombah.com
 * Created on	:	20 October 2010
 * Author 		:	Faisel
 + Project		: 	Job site
 * File Name	:	views/adminconfig/tmpl/config.php
 * License		:	GNU General Public License version 3, or later
 ^ 
 * Description	: 	Show the configuration settings (jbjobs)
 ^ 
 * History		:	NONE
 ^ 
 * */
 defined('_JEXEC') or die('Restricted access');
 jimport('joomla.html.pane');
 $pane =& JPane::getInstance('tabs', array('startOffset'=>0)); 
 $model = $this->getModel();
 ?>
 <form action="index.php" method="post" name="adminForm">
 	<?php echo $pane->startPane( 'pane' ); 
	  	  echo $pane->startPanel( JText::_('Global'), 'global' ); ?>
		
			<fieldset class="adminform">
			<legend><?php echo JText::_( 'Global' ); ?></legend>
			<table class="admintable">
			
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Welcome Title' ); ?>:</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="welcome_title" id="welcome_title" size="60" maxlength="100" value="<?php echo $this->row->welcome_title; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Welcome message shown in the front page'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Free Mode' ); ?>:</label>
					</td>
					<td>
						<?php $free_mode = $model->YesNoBool('freemode', $this->row->freemode ? $this->row->freemode : 0);
						echo  $free_mode;	?>
					</td>
					<td width="50%">
						<?php echo JText::_('If set to \'yes\', all the financial related items are disabled for employers'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Limit job expire days in free mode' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="limittimeforfreemode" id="limittimeforfreemode" size="5" maxlength="100" value="<?php echo $this->row->limittimeforfreemode; ?>" />
						<?php echo JText::_('Days'); ?>
					</td>
					<td width="50%">
						<?php echo JText::_('Enter the number of days, jobs published by employers be active, when set in free mode. Example 5'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Currency Symbol' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="currencysymbol" id="currencysymbol" size="5" maxlength="10" value="<?php echo $this->row->currencysymbol; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Example, $ or £'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Currency Code' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="currencycode" id="currencycode" size="5" maxlength="5" value="<?php echo $this->row->currencycode; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Example, BND or USD'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Article ID for Term of Service page' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="termarticleid" id="termarticleid" size="5" maxlength="5" value="<?php echo $this->row->termarticleid; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Enter the id of the article for showing Terms & Conditions during registration'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'RSS Limit' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="rsslimit" id="rsslimit" size="5" maxlength="5" value="<?php echo $this->row->rsslimit; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Set the number to limit number of jobs in the RSS'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Show RSS?' ); ?>:</label>
					</td>
					<td>
						<?php $enable_rss = $model->YesNoBool('enablerss', $this->row->enablerss);
						echo  $enable_rss; ?>
					</td>
					<td width="50%">
						<?php echo JText::_('Show/hide RSS icon in front-end'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Show JoomBah Credit info?' ); ?>:</label>
					</td>
					<td>
						<?php $show_jbcredit = $model->YesNoBool('showjbcredit', $this->row->showjbcredit);
						echo  $show_jbcredit; ?>
					</td>
					<td width="50%">
						<?php echo JText::_('Show/hide &quot;Powered by JoomBah&quot; in front-end'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Show Shared Bookmarks?' ); ?>:</label>
					</td>
					<td>
						<?php $show_bookmark = $model->YesNoBool('showbookmark', $this->row->showbookmark); 
						echo  $show_bookmark; ?>
					</td>
					<td width="50%">
						<?php echo JText::_('Show/hide Shared Bookmarks in Job detail page'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Enable Employer Registration?' ); ?>:</label>
					</td>
					<td>
						<?php $enable_emp_reg = $model->YesNoBool('enableempreg', $this->row->enableempreg);
						echo  $enable_emp_reg; ?>
					</td>
					<td width="50%">
						<?php echo JText::_('Set to \'No\', to disable Employer\'s Registration'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Enable Jobseeker Registration?' ); ?>:</label>
					</td>
					<td>
						<?php $enable_js_reg = $model->YesNoBool('enablejsreg', $this->row->enablejsreg);
						echo  $enable_js_reg; ?>
					</td>
					<td width="50%">
						<?php echo JText::_('Set to \'No\', to disable Jobseeker\'s Registration'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Show CAPTCHA in Registration?' ); ?>:</label>
					</td>
					<td>
						<?php $enable_captcha = $model->YesNoBool('showcaptcha', $this->row->showcaptcha);
						echo  $enable_captcha; ?>
					</td>
					<td width="50%">
						<?php echo JText::_('Show/hide CAPTCHA in the registration page'); ?>	
					</td>
				</tr>
		    </table>
			</fieldset>
		
		<?php  echo $pane->endPanel();
		
		echo $pane->startPanel( JText::_('Credit'), 'credit' ); ?>
		
			<fieldset class="adminform">
			<legend><?php echo JText::_( 'Credit' ); ?></legend>
			<table class="admintable">
			
				<!--<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Price of 1 Credit' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="creditprice" id="creditprice" size="5" maxlength="5" value="<?php echo $this->row->creditprice; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Enter the price for one credit. Example 5. Do not enter currency symbol'); ?>	
					</td>
				</tr>-->
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Min. credit purchase' ); ?>:</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="creditmin" id="creditmin" size="5" maxlength="5" value="<?php echo $this->row->creditmin; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Enter the minimum credit that employers can purchase. Example 5.'); ?>	
					</td>
				</tr>
				<!--<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Bonus credit during registration' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="creditbonus" id="creditbonus" size="5" maxlength="5" value="<?php echo $this->row->creditbonus; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Enter number of credits to be given as bonus for employers during registration. Example 5.'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'How many credits per job?' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="creditperjob" id="creditperjob" size="5" maxlength="5" value="<?php echo $this->row->creditperjob; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Enter number of credits you wish to charge or deduce from employers account. Example 2'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Job expires (Max. days)' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="jobexpire" id="jobexpire" size="5" maxlength="5" value="<?php echo $this->row->jobexpire; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Limit the job\'s expire day. If set to 30, maximum days the job is active becomes 30 days'); ?>	
					</td>
				</tr>-->
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Tax Name' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="taxname" id="taxname" size="25" maxlength="30" value="<?php echo $this->row->taxname; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Enter your country\'s tax name. Example, VAT'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Tax in percent' ); ?>:</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="taxpercent" id="taxpercent" size="8" maxlength="8" value="<?php echo $this->row->taxpercent; ?>" /> %
					</td>
					<td width="50%">
						<?php echo JText::_('Enter the percentage of tax. Do not include % symbol. Example, 12.5'); ?>	
					</td>
					<tr>
					<td colspan="2"><a href="index.php?option=com_jbjobs&view=adminconfig&layout=showplan">Click here</a> to change the credit settings for each plans.
					</td>
				</tr>
				</tr>
		    </table>
			</fieldset>
		
		<?php  echo $pane->endPanel(); 
		echo $pane->startPanel( JText::_('Payment'), 'payment' ); ?>
		
			<fieldset class="adminform">
			<legend><?php echo JText::_( 'PayPal' ); ?></legend>
			<table class="admintable">
			
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'PayPal Account' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="paypalaccount" id="paypalaccount" size="50" maxlength="60" value="<?php echo $this->row->paypalaccount; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Enter your PayPal account id to which payment will be made'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'PayPal Currency Code (Eg. USD, BND)' ); ?>:</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="paypalcurrcode" id="paypalcurrcode" size="5" maxlength="5" value="<?php echo $this->row->paypalcurrcode; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Enter the PayPal recognised currency code. Example, SGD or USD'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Test Mode (Need Paypal Sandbox Account)' ); ?>:</label>
					</td>
					<td>
						<?php $test_mode = $model->YesNoBool('paypaltest', $this->row->paypaltest);
						echo  $test_mode; ?>
					</td>
					<td width="50%">
						<?php echo JText::_('Set to Yes, if you wish to test your payment through PayPal. To sign up, visit http://www.sandbox.paypal.com'); ?>	
					</td>
				</tr>
				
		    </table>
			</fieldset>
			
			<fieldset class="adminform">
			<legend><?php echo JText::_( 'Manual Transfer' ); ?></legend>
			<table class="admintable">
			
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Bank Account Number' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="bankaccnum" id="bankaccnum" size="20" maxlength="25" value="<?php echo $this->row->bankaccnum; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Enter your Bank account number'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Bank Name' ); ?>:</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="bankname" id="bankname" size="50" maxlength="50" value="<?php echo $this->row->bankname; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Enter your Bank name'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Account Holder\'s Name' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="accholdername" id="accholdername" size="50" maxlength="50" value="<?php echo $this->row->accholdername; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Enter bank account holder\'s name'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'IBAN' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="iban" id="iban" size="50" maxlength="50" value="<?php echo $this->row->iban; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('International Bank Account Number (IBAN) is a 21 digit alphanumeric characters. Enter, if you have any.'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'SWIFT' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="swift" id="swift" size="50" maxlength="50" value="<?php echo $this->row->swift; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Society for Worldwide Interbank Financial Telecommunication (SWIFT). Enter, if you have any.'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'My Invoice Details' ); ?>:</label>
					</td>
					<td >
						<textarea id="myinvoicedetails" name="myinvoicedetails" rows="6" cols="30"><?php echo $this->row->myinvoicedetails; ?></textarea>
					</td>
					<td width="50%">
						<?php echo JText::_('Enter your invoice details that will appear in the invoice of employers. Please add &lt;br/&gt; at the end of each line'); ?>	
					</td>
				</tr>
				
		    </table>
			</fieldset>
			
			<fieldset class="adminform">
			<legend><?php echo JText::_( 'Nofification' ); ?></legend>
			<table class="admintable">
			
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Email' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="notifyemail" id="notifyemail" size="50" maxlength="50" value="<?php echo $this->row->notifyemail; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Enter your Email address to which employers notify in case of manual transfer. Example, notify@mysite.com'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Fax No' ); ?>:</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="notifyfax" id="notifyfax" size="50" maxlength="50" value="<?php echo $this->row->notifyfax; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Enter your fax number to which employers notify in case of manual transfer'); ?>	
					</td>
				</tr>
				
		    </table>
			</fieldset>
		
		<?php  echo $pane->endPanel(); 
		echo $pane->startPanel( JText::_('Uploads'), 'uploads' ); ?>
		
			<fieldset class="adminform">
			<legend><?php echo JText::_( 'Resume / CV' ); ?></legend>
			<table class="admintable">
			
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Legal MIME types' ); ?>:</label>
					</td>
					<td >
						<textarea id="cvfiletype" name="cvfiletype" rows="6" cols="30"><?php echo $this->row->cvfiletype; ?></textarea>
					</td>
					<td width="50%">
						<?php echo JText::_('Specify here which images MIME types are allowed for upload. Use comma separated, lowercase lists without spaces. Example: application/msword,application/excel,application/pdf'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Text in upload field' ); ?>:</label>
					</td>
					<td>
						<textarea id="cvfiletext" name="cvfiletext" rows="3" cols="30"><?php echo $this->row->cvfiletext; ?></textarea>
					</td>
					<td width="50%">
						<?php echo JText::_('Enter the allowed file types that will be shown to end users. Example: jpg, gif, word, excel, pdf, zip'); ?>	
					</td>
				</tr>
				
		    </table>
			</fieldset>
			
			<fieldset class="adminform">
			<legend><?php echo JText::_( 'Images' ); ?></legend>
			<table class="admintable">
				
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Allowed image types' ); ?>:</label>
					</td>
					<td >
						<textarea id="imgfiletype" name="imgfiletype" rows="6" cols="30"><?php echo $this->row->imgfiletype; ?></textarea>
					</td>
					<td width="50%">
						<?php echo JText::_('Specify here which images MIME types are allowed for upload. Use comma separated, lowercase lists without spaces. Example: image/jpeg,image/jpg,image/gif,image/png'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Width' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="imgwidth" id="imgwidth" size="10" maxlength="10" value="<?php echo $this->row->imgwidth; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Height' ); ?>:</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="$imgheight" id="$imgheight" size="10" maxlength="10" value="<?php echo $this->row->imgheight; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Max. Size in KB' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="imgmaxsize" id="imgmaxsize" size="10" maxlength="10" value="<?php echo $this->row->imgmaxsize; ?>" />
					</td>
				</tr>
				
		    </table>
			</fieldset>
		
		<?php  echo $pane->endPanel(); 
		echo $pane->startPanel( JText::_('Integration'), 'integration' ); ?>
		
			<fieldset class="adminform">
			<legend><?php echo JText::_( 'Social Component' ); ?></legend>
			<table class="admintable">
			
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'User Profile' ); ?>:</label>
					</td>
					<td >
						<?php $user_profile = $model->getSelectUserProfile('userprofile', $this->row->userprofile, 0);
						echo  $user_profile; ?>
					</td>
				</tr>
				
		    </table>
			</fieldset>
			
			<fieldset class="adminform">
			<legend><?php echo JText::_( 'Indeed.com' ); ?></legend>
			<table class="admintable">
			
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Enable Indeed.com?' ); ?>:</label>
					</td>
					<td >
						<?php $enable_indeed = $model->YesNoBool('indeedenable', $this->row->indeedenable);
						echo  $enable_indeed; ?>
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Publisher ID' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="indeedpubid" id="indeedpubid" size="30" maxlength="30" value="<?php echo $this->row->indeedpubid; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('To create a FREE account and recieve your Publisher ID and access tool, visit http://www.indeed.com/jsp/apiinfo.jsp'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Keywords' ); ?>:</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="indeedkey" id="indeedkey" size="50" maxlength="50" value="<?php echo $this->row->indeedkey; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Enter job titles/keywords. Example: Java Developer, Network Engineer'); ?>	
					</td>
				</tr>
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Location' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="indeedlocate" id="indeedlocate" size="50" maxlength="50" value="<?php echo $this->row->indeedlocate; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Enter the location name/city. Example: Singapore, Delhi, Washington'); ?>	
					</td>
				</tr>
				
				<tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Country Code' ); ?>:</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="indeedcountry" id="indeedcountry" size="3" maxlength="10" value="<?php echo $this->row->indeedcountry; ?>" />
					</td>
					<td width="50%">
						<?php echo JText::_('Enter the Country code supported by Indeed.com. To get it, visit https://ads.indeed.com/jobroll/xmlfeed after loggin in'); ?>	
					</td>
				</tr>
				
		    </table>
			</fieldset>
		
		<?php  echo $pane->endPanel(); ?>
	<?php echo $pane->endPane();?>
	<input type="hidden" name="option" value="com_jbjobs" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="boxchecked" value="0" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>