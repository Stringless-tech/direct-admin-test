<?php

class Validator
{
	private $errors = [];
		
	public function isValid(): bool
	{
		return empty($this->errors);
	}
	
	public function getErrors(): array
    	{
        		return $this->errors;
    	}
	
	public function validateRequired(array $rule, string $string): bool
	{
		if($string == '' && $rule['required'] === true)
		{
			$this->errors[$rule['fieldName']] = 'To pole jest wymagane';
			return false;
		}
		
		return true;
	}
		
	public function validatePassword(array $rule, string $string): bool
	{
		if(strlen($string) < $rule['min_length'])
		{
			$this->errors[$rule['fieldName']] = 'Hasło wymaga przynamniej 5 znaków';
			return false;
		}
		
		return true;
	}
	
	public function validateEmail(array $rule, string $string): bool
	{
		if(filter_var($string, FILTER_VALIDATE_EMAIL) === false && $rule['valid'] === true )
		{
			$this->errors[$rule['fieldName']] = 'Email ma nieprawidłowy format';
			return false;
		}
		else
			return true;
	}
	
	public function validateUsername(array $rule, string $string): bool
	{
		if(strlen($string) < $rule['minLength'] || strlen($string) > $rule['maxLength'])
		{
			$this->errors[$rule['fieldName']] = 'Nazwa użytkownika powinna mieć od 4 do 8 znaków';
			return false;
		}
		
		if($rule['alphanumeric'] === true && !ctype_alnum($string))
		{
			$this->errors[$rule['fieldName']] = 'Nazwa użytkownika powinna zawierać znaki alfanumeryczne';
			return false;
		}
		
		return true;
	}
	
	public function validateData(array $data): bool
	{
		$rules = [
			[
				'fieldName' => 'username',
				'minLength' => 4,
				'maxLength' => 8,
				'alphanumeric' => true,
				'required' => true,
			],
			[
				'fieldName' => 'email',
				'valid' => true,
				'required' => true,
			],
			[
				'fieldName' => 'password',
				'min_length' => 5,
				'required' => true,
			],
			[
				'fieldName' => 'domain',
				'required' => true,			
			],						
		];
		
		foreach($rules as $rule)
		{
			if(!$this->validateRequired($rule,$data[$rule['fieldName']]))
				continue;
			switch($rule['fieldName'])
			{
				case 'username':
					$this->validateUsername($rule,$data['username']);
					break;
				case 'email':
					$this->validateEmail($rule,$data['email']);
					break;
				case 'password':
					$this->validatePassword($rule, $data['password']);
					break;
			}
		}

		return $this->isValid();
		
	}
}