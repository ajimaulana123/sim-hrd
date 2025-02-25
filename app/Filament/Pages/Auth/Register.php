<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use App\Models\Employee;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Support\Facades\Hash;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Notification;

class Register extends BaseRegister
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                    
                TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                    
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(User::class)
                    ->maxLength(255),
                    
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->same('passwordConfirmation'),
                    
                TextInput::make('passwordConfirmation')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->label('Confirm Password'),
                    
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                    
                Select::make('gender')
                    ->required()
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ]),
                    
                DatePicker::make('birth_date')
                    ->required()
                    ->maxDate(now()->subYears(18)),
            ]);
    }

    public function register(): ?RegistrationResponse
    {
        try {
            $data = $this->form->getState();
            
            // Create employee record
            $employee = Employee::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'gender' => $data['gender'],
                'birth_date' => $data['birth_date'],
                'hire_date' => now(),
                'status' => 'active',
                'address' => '',  // Will be updated later
                'department_id' => 1,  // Default department, can be updated by admin
                'position_id' => 1,    // Default position, can be updated by admin
                'salary' => 0,         // Will be set by admin
            ]);
            
            // Create user account
            $user = User::create([
                'name' => $data['first_name'] . ' ' . $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'employee',
                'employee_id' => $employee->id,
            ]);
            
            $this->auth()->login($user);
            
            Notification::make()
                ->title('Registration successful')
                ->success()
                ->send();

            return $this->getRegistrationResponse();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Registration failed')
                ->body('An error occurred during registration. Please try again.')
                ->danger()
                ->send();
                
            return null;
        }
    }
} 