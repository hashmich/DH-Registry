<?php 
/**
 * Copyright 2014 Hendrik Schmeer on behalf of DARIAH-EU, VCC2 and DARIAH-DE,
 * Credits to Erasmus University Rotterdam, University of Cologne, PIREH / University Paris 1
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

//$this->extend(APP . 'Plugin/Users/View/Users/register.ctp');
//$this->start('Users.details');

// view extension doesn't work well with Cake's form validation.
?>

<?php
$this->Html->script('https://www.google.com/recaptcha/api.js', array('inline' => false));
$this->Html->scriptStart(array('inline' => false));
?>
function recaptchaCallback(token) {
	document.getElementById("AppUserRegisterForm").submit();
}
<?php $this->Html->scriptEnd(); ?>

<div class="users_form">
	<h2>User Registration</h2>
	
    <?php
    if(!empty($this->Session->read('Users.verification'))) {
        ?>
        <div class="actions">
            <ul>
                <li>
                    <?php
                    echo $this->Html->link('Resend verification mail', array(
                        'action' => 'resend_email_verification',
                        'controller' => 'users'
                    ), array(
                        'title' => 'If you already registered, but have not verified your email address, please click here.'));
                    ?>
                </li>
            </ul>
        </div>
        <?php
    }
    ?>

	<?php
	echo $this->element('Utils.validation_errors');
	
	echo $this->Form->create($modelName, array('novalidate' => true));
	?>
	
    
    <fieldset>
        <p>
            If you are lecturer or member of an academic institution in the field of digital humanities,
            please register here.
            After approval of a moderator, you can add your courses to the registry.
        </p>
    </fieldset>
    
    
	<fieldset>
    <?php
	if(empty($shibUser)){
		?>
		<h3>Log in with your institutional account</h3>
		<p>
			Many institutions are connected to a federated single sign-on network, 
			that provide access to various services with a single account. <br>
			Please check, if you can find your institution using the link below. <br>
			After logging in via your institutional account and finalizing the 
			DH Course Registry registration, you will be able to login to our service with 
			your institutional account. 
		</p>
		<p>
			<?php $url = urlencode(Router::url('/users/register', $full = true)); ?>
			<a href="<?php echo Configure::read('shib.idpSelect') . $url; ?>"
               onclick="alert('Single Sign-On is having problems at the moment. We are working on a solution...')">
				Select your institution
			</a>
			(you will be redirected to an external website).
		</p>
		<?php
	}else{
		?>
		<h3>Connection to institutional account</h3>
		<p>
			You have been successfully identified as 
			<b>
				<?php
				echo (!empty($shibUser['first_name']) AND !empty($shibUser['last_name']))
					? $shibUser['first_name'] . ' ' . $shibUser['last_name']
					: (!empty($shibUser['first_name']) OR !empty($shibUser['last_name']))
						? $shibUser['first_name'] . $shibUser['last_name']
						: '';
				?>
			</b>
		</p>
		<p class="strong">
			Please continue registration to the DH Course 
			Registry by completing the form below.
		</p>
		<?php
		echo $this->Form->input('shib_eppn', array(
			'type' => 'hidden',
			'value' => $shibUser['shib_eppn']
		));
	}
	
	echo '</fieldset>';
	echo '<fieldset>';
	
	echo $this->Form->input('email', array(
		'label' => 'E-mail',
		'autocomplete' => 'off',
		'default' => (empty($shibUser['email'])) ? null : $shibUser['email']
	));
	
	echo $this->Form->input('password', array(
		'label' => 'Password',
		'type' => 'password',
		'autocomplete' => 'off'
	));
	
	echo '</fieldset>';
	echo '<fieldset>';
	
	echo $this->Form->input('institution_id', array(
		'label' => 'Institution (*)',
		'empty' => '-- choose institution --',
		'required' => false
	));
	
	echo $this->Form->input('university', array(
		'label' => 'Other Institution',
		'type' => 'textarea',
		'placeholder' => 'If you cannot find your institution in the dropdown list above, please provide country, city and name of your institution.'
	));
	
	echo '</fieldset>';
	echo '<fieldset>';
	
	echo $this->Form->input('academic_title');
	
	echo $this->Form->input('first_name', array(
		'default' => (empty($shibUser['first_name'])) ? null : $shibUser['first_name']
	));
	
	echo $this->Form->input('last_name', array(
		'default' => (empty($shibUser['last_name'])) ? null : $shibUser['last_name']
	));
	
	echo $this->Form->input('about', array(
		'type' => 'textarea',
		'placeholder' => 'Please provide some details about who you are and your institutional occupation, 
so that our moderators get an idea of your involvement into Digital Humanities.',
	));
	
	echo '</fieldset>';
	?>
 
	<fieldset>
        <p>
            By registering an account for the Digital Humanities Course Registry,
            you agree to the processing of your personal data for the purposes of this service.
            Your personal data is stored and processed by the ACDH but not made public or shared with third parties.
            In case you act as national moderator or administrator of the Digital Humanities Course Registry,
            your name, country and e-mail address will be shared publicly
            in order to enable all visitors to contact you.
            Your contact data will remain published until you resign from any assigned role.
            The deletion of your account and the associated personal data can be
            requested at any time via our
            <?= $this->Html->link('contact page', Configure::read('dhcr.baseUrl').'pages/info#contact') ?>.
        </p>
        <?php echo $this->Form->input('consent', [
            'type' => 'checkbox',
            'label' => 'I agree',
            'required' => true,
            'value' => 1
        ]); ?>
	</fieldset>
	
    <?php
	echo $this->Form->end(array(
		'label' => 'Submit',
		'class' => 'g-recaptcha',
		'data-sitekey' => Configure::read('App.reCaptchaPublicKey'),
		'data-callback' => 'recaptchaCallback'
	));
	?>
	
</div>
