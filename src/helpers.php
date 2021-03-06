<?php

use Acacha\Relationships\Models\Contact;
use Acacha\Relationships\Models\ContactType;
use Acacha\Relationships\Models\Identifier;
use Acacha\Relationships\Models\IdentifierType;
use Acacha\Relationships\Models\Address;
use Acacha\Relationships\Models\Location;
use Acacha\Relationships\Models\Person;
use Acacha\Relationships\Models\Photo;
use App\User;
use Faker\Factory;
use Spatie\Permission\PermissionRegistrar;

if (! function_exists('create')) {
    /**
     * Create
     *
     * @param $class
     * @param array $attributes
     * @return mixed
     */
    function create($class, $attributes = []) {
        return factory($class)->create($attributes);
    }
}

if (! function_exists('make')) {
    /**
     * Make
     *
     * @param $class
     * @param array $attributes
     * @return mixed
     */
    function make($class,$attributes = []) {
        return factory($class)->make($attributes);
    }
}


if (! function_exists('initialize_relationships_management_permissions')) {

    /**
     * Initialize staff management permissions and roles.
     */
    function initialize_relationships_management_permissions()
    {
        $superAdmin = role_first_or_create('super-admin-manage-relationships');

        //Disable validation
        permission_first_or_create('disable-validation');
        give_permission_to_role($superAdmin,'disable-validation');

        $manageRelationships = role_first_or_create('manage-relationships');

        //Disable strict validation
        permission_first_or_create('disable-strict-validation');
        give_permission_to_role($manageRelationships,'disable-strict-validation');

        //Relationships MANAGEMENT
        permission_first_or_create('search-by-identifier');
        give_permission_to_role($manageRelationships,'search-by-identifier');

        //PersonPhoto
        permission_first_or_create('list-person-photos');
        permission_first_or_create('store-person-photo');
        permission_first_or_create('show-person-photo');
        permission_first_or_create('update-person-photo');
        permission_first_or_create('destroy-person-photo');
        give_permission_to_role($manageRelationships,'list-person-photos');
        give_permission_to_role($manageRelationships,'store-person-photo');
        give_permission_to_role($manageRelationships,'show-person-photo');
        give_permission_to_role($manageRelationships,'update-person-photo');
        give_permission_to_role($manageRelationships,'destroy-person-photo');

        //PhotoController
        permission_first_or_create('show-photos');
        permission_first_or_create('post-photos');
        permission_first_or_create('destroy-photos');
        give_permission_to_role($manageRelationships,'show-photos');
        give_permission_to_role($manageRelationships,'post-photos');
        give_permission_to_role($manageRelationships,'destroy-photos');

        //User Relationships
        permission_first_or_create('show-user-relationships');
        give_permission_to_role($manageRelationships,'show-user-relationships');

        //Identifiers
        permission_first_or_create('list-identifiers');
        give_permission_to_role($manageRelationships,'list-identifiers');

        //Search identifiers
        permission_first_or_create('search-identifiers');
        give_permission_to_role($manageRelationships,'search-identifiers');

        //Fullnames
        permission_first_or_create('list-fullnames');
        give_permission_to_role($manageRelationships,'list-fullnames');

        //Person
        permission_first_or_create('show-person');
        permission_first_or_create('store-person');
        permission_first_or_create('update-person');
        give_permission_to_role($manageRelationships,'show-person');
        give_permission_to_role($manageRelationships,'store-person');
        give_permission_to_role($manageRelationships,'update-person');

        //Locations
        permission_first_or_create('list-locations');
        give_permission_to_role($manageRelationships,'list-locations');

        app(PermissionRegistrar::class)->registerPermissions();

    }
}

if (! function_exists('first_user_as_relationships_manager')) {
    /**
     * Seed teachers.
     */
    function first_user_as_relationships_manager()
    {
        initialize_relationships_management_permissions();
        $user = User::all()->first();
        $user->assignRole('manage-relationships');
    }
}

if (! function_exists('seed_locations')) {
    /**
     * Seed locations.
     */
    function seed_locations()
    {
        Artisan::call('seed:locations');
    }
}

if (! function_exists('first_or_create_location')) {
    /**
     * First or create location.
     *
     * @param $location
     * @param $postalcode
     * @return mixed
     */
    function first_or_create_location($location, $postalcode )
    {
        try {
            return Location::create([
                'name' => $location,
                'postalcode' => $postalcode
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            return Location::where([
                'name' => $location,
                'postalcode' => $postalcode
            ]);
        }
    }
}

if (! function_exists('first_or_create_contact_type')) {
    /**
     * Create contact type if not exists and return new o already existing contact type.
     */
    function first_or_create_contact_type($name)
    {
        try {
            return ContactType::create(['name' => $name]);
        } catch (Illuminate\Database\QueryException $e) {
            return ContactType::where('name', $name);
        }
    }
}

if (! function_exists('seed_contact_types')) {
    /**
     * Create contact_types.
     */
    function seed_contact_types()
    {
        first_or_create_contact_type('Telèfon');
        first_or_create_contact_type('email');
        first_or_create_contact_type('TODO');
    }
}

if (! function_exists('obtainContactTypeByName')) {
    /**
     * Obtain contact type by name.
     */
    function obtainContactTypeByName($name)
    {
        ContactType::where('name',$name)->first()->id;
    }
}

if (! function_exists('first_or_create_contact')) {
    /**
     * Create contact if not exists and return new o already existing contact.
     */
    function first_or_create_contact($value, $type)
    {
        try {
            return Contact::create([
                'value' => $value,
                'contact_type_id' => obtainContactTypeIdByName($type)
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            return Contact::where('value', $value);
        }
    }
}

if (! function_exists('obtainContactTypeIdByName')) {
    /**
     * Obtain contact type id by name.
     */
    function obtainContactTypeIdByName($name)
    {
        return ContactType::where('name', $name)->first()->id;
    }
}


if (! function_exists('first_or_create_identifier_type')) {
    /**
     * Create contact type if not exists and return new o already existing contact type.
     */
    function first_or_create_identifier_type($name)
    {
        try {
            return IdentifierType::create(['name' => $name]);
        } catch (Illuminate\Database\QueryException $e) {
            return IdentifierType::where('name', $name);
        }
    }
}

if (! function_exists('seed_identifier_types')) {
    /**
     * Create identifier types.
     */
    function seed_identifier_types()
    {
        first_or_create_identifier_type('NIF');
        first_or_create_identifier_type('Pasaporte');
        first_or_create_identifier_type('NIE');
        first_or_create_identifier_type('TIS');
    }
}

if (! function_exists('seed_identifiers')) {
    /**
     * Create identifiers.
     */
    function seed_identifiers()
    {
        Artisan::call('seed:identifiers');
    }
}

if (! function_exists('seed_random_nif_identifiers')) {
    /**
     * Create identifiers.
     */
    function seed_random_nif_identifiers($number = 100)
    {
        factory(Identifier::class,$number)->states('nif')->create();
    }
}


if (! function_exists('first_or_create_identifier')) {
    /**
     * Create identifier if not exists and return new o already existing identifier.
     */
    function first_or_create_identifier($value, $type)
    {
        try {
            return Identifier::create([
                'value' => $value,
                'type_id' => $type
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            return Contact::where('value', $value);
        }
    }
}


if (! function_exists('seed_states')) {
    function seed_states()
    {

        DB::table('states')->delete();


        // Taken from //https://gist.github.com/daguilarm/0e93b73779f0306e5df2
        DB::table('states')->insert([
            ['id' => '1', 'country_code' => "ESP", 'name' => "Andalucía", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '2', 'country_code' => "ESP", 'name' => "Aragón", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '3', 'country_code' => "ESP", 'name' => "Asturias, Principado de", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '4', 'country_code' => "ESP", 'name' => "Baleares, Islas", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '5', 'country_code' => "ESP", 'name' => "Canarias", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '6', 'country_code' => "ESP", 'name' => "Cantabria", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '7', 'country_code' => "ESP", 'name' => "Castilla y León", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '8', 'country_code' => "ESP", 'name' => "Castilla - La Mancha", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '9', 'country_code' => "ESP", 'name' => "Cataluña", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '10', 'country_code' => "ESP", 'name' => "Comunidad Valenciana", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '11', 'country_code' => "ESP", 'name' => "Extramadura", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '12', 'country_code' => "ESP", 'name' => "Galicia", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '13', 'country_code' => "ESP", 'name' => "Madrid, Comunidad de", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '14', 'country_code' => "ESP", 'name' => "Murcia, Región de", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '15', 'country_code' => "ESP", 'name' => "Navarra, Comunidad Foral de", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '16', 'country_code' => "ESP", 'name' => "País Vasco", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '17', 'country_code' => "ESP", 'name' => "Rioja, La", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '18', 'country_code' => "ESP", 'name' => "Ceuta", 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '19', 'country_code' => "ESP", 'name' => "Melilla", 'created_at' => new DateTime, 'updated_at' => new DateTime]
        ]);
    }
}

if (! function_exists('seed_provinces')) {
    function seed_provinces()
    {
        seed_states();

        DB::table('provinces')->delete();


        // Taken from //https://gist.github.com/daguilarm/0e93b73779f0306e5df2
        DB::table('provinces')->insert([
            ['id' => '1','state_id' => 8, 'name' => 'Albacete', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '2','state_id' => 8, 'name' => 'Ciudad Real', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '3','state_id' => 8, 'name' => 'Cuenca', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '4','state_id' => 8, 'name' => 'Guadalajara', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '5','state_id' => 8, 'name' => 'Toledo', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '6','state_id' => 2, 'name' => 'Huesca', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '7','state_id' => 2, 'name' => 'Teruel', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '8','state_id' => 2, 'name' => 'Zaragoza', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '9','state_id' => 18, 'name' => 'Ceuta', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '10','state_id' => 13, 'name' => 'Madrid', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '11','state_id' => 14, 'name' => 'Murcia', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '12','state_id' => 19, 'name' => 'Melilla', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '13','state_id' => 15, 'name' => 'Navarra', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '14','state_id' => 1, 'name' => 'Almería', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '15','state_id' => 1, 'name' => 'Cádiz', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '16','state_id' => 1, 'name' => 'Córdoba', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '17','state_id' => 1, 'name' => 'Granada', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '18','state_id' => 1, 'name' => 'Huelva', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '19','state_id' => 1, 'name' => 'Jaén', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '20','state_id' => 1, 'name' => 'Málaga', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '21','state_id' => 1, 'name' => 'Sevilla', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '22','state_id' => 3, 'name' => 'Asturias', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '23','state_id' => 6, 'name' => 'Cantabria', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '24','state_id' => 7, 'name' => 'Ávila', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '25','state_id' => 7, 'name' => 'Burgos', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '26','state_id' => 7, 'name' => 'León', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '27','state_id' => 7, 'name' => 'Palencia', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '28','state_id' => 7, 'name' => 'Salamanca', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '29','state_id' => 7, 'name' => 'Segovia', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '30','state_id' => 7, 'name' => 'Soria', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '31','state_id' => 7, 'name' => 'Valladolid', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '32','state_id' => 7, 'name' => 'Zamora', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '33','state_id' => 9, 'name' => 'Barcelona', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '34','state_id' => 9, 'name' => 'Gerona', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '35','state_id' => 9, 'name' => 'Lérida', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '36','state_id' => 9, 'name' => 'Tarragona', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '37','state_id' => 11, 'name' => 'Badajoz', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '38','state_id' => 11, 'name' => 'Cáceres', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '39','state_id' => 12, 'name' => 'Coruña, La', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '40','state_id' => 12, 'name' => 'Lugo', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '41','state_id' => 12, 'name' => 'Orense', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '42','state_id' => 12, 'name' => 'Pontevedra', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '43','state_id' => 17, 'name' => 'Rioja, La', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '44','state_id' => 4, 'name' => 'Baleares, Islas', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '45','state_id' => 16, 'name' => 'Álava', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '46','state_id' => 16, 'name' => 'Guipúzcoa', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '47','state_id' => 16, 'name' => 'Vizcaya', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '48','state_id' => 5, 'name' => 'Palmas, Las', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '49','state_id' => 5, 'name' => 'Tenerife, Santa Cruz De', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '50','state_id' => 10, 'name' => 'Alicante', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '51','state_id' => 10, 'name' => 'Castellón', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '52','state_id' => 10, 'name' => 'Valencia', 'created_at' => new DateTime, 'updated_at' => new DateTime]
        ]);
    }
}

if (! function_exists('obtainProvinceByPostalCode')) {
    /**
     * Obtain province by postal code.
     *
     * @param $code
     * @return mixed
     */
    function obtainProvinceByPostalCode($code)
    {
        return Province::first();
    }
}

if (! function_exists('obtainProvinceIdByPostalCode')) {
    /**
     * Obtain province id by postal code.
     *
     * @param $code
     * @return mixed
     */
    function obtainProvinceIdByPostalCode($code)
    {
        return Province::first()->id;
    }
}

if (! function_exists('first_or_create_address')) {
    /**
     * Create address if not exists and return new o already existing address.
     *
     * @param $fullname
     * @param null $name
     * @param null $type
     * @param null $number
     * @param null $floor
     * @param null $floor_number
     * @param null $postalcode
     * @param null $location
     * @param null $province
     * @param string $country_code
     * @return mixed
     */
    function first_or_create_address(
        $fullname,
        $name = null,
        $type = null,
        $number = null,
        $floor = null,
        $floor_number = null,
        $location = null,
        $province = null,
        $country_code = "ESP"
    )
    {
        try {
            return Address::create([
                'name' => $name,
                'fullname' => $fullname,
                'type' => $type,
                'number' => $number,
                'floor' => $floor,
                'floor_number' => $floor_number,
                'location' => $location,
                'province_id' => $province,
                'country_code' => $country_code
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            dd($e);
            return Contact::where('fullname', $fullname);
        }
    }
}

if (! function_exists('seed_photos')) {
    function seed_photos()
    {
        Artisan::call('seed:photos', [
            '--skip-download' => true
        ]);
    }
}

if (! function_exists('seed_contacts')) {
    function seed_contacts()
    {
        Artisan::call('seed:contacts');
    }
}

if (! function_exists('seed_addresses')) {
    function seed_addresses()
    {
        Artisan::call('seed:addresses');
    }
}

if (! function_exists('first_or_create_people')) {
    /**
     * First or create people.
     *
     * @param $name
     * @param $givenName
     * @param $surname
     * @param $surname1
     * @param $surname2
     * @param $birthdate
     * @param $birthplace_id
     * @param $birthplace_id
     * @param $gender
     * @param $civil_status
     */
    function first_or_create_people(
        $name,
        $givenName,
        $surname,
        $surname1,
        $surname2,
        $birthdate,
        $birthplace_id,
        $gender,
        $civil_status,
        $notes
    )
    {
        try {
            $existingUser = Person::where([
                    'name' => $name,
                    'gender' => $gender,
                ], trim($name));
            if ($existingUser->count() > 0) {
                if (trim($existingUser->first()->gender) === trim($gender)) {
                    if ($existingUser->first()->birthdate === $birthdate) {
                        return;
                    };
                };
            }

            return Person::create([
                'name' => $name,
                'givenName' => $givenName,
                'surname' => $surname,
                'surname1' => $surname1,
                'surname2' => $surname2,
                'birthdate' => $birthdate,
                'birthplace_id' => $birthplace_id,
                'gender' => $gender,
                'civil_status' => $civil_status,
                'notes' => $notes
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            return;
        }
    }
}
if (! function_exists('first_or_create_user')) {
    /**
     * First or create user.
     *
     * @param $name
     * @param $email
     * @param $password
     * @param $initialPassword
     * @return mixed
     */
    function first_or_create_user($name, $email, $password, $initialPassword)
    {
        try {
            return User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'initialPassword' => $initialPassword
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            return User::where('email', $email)->first();
        }
    }
}

if (! function_exists('first_or_create_photo')) {
    /**
     *
     * First or create photo.
     *
     * @param $storage
     * @param $path
     * @return mixed
     */
    function first_or_create_photo($storage, $path)
    {
        try {
            return Photo::create([
                'storage' => $storage,
                'path' => $path
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            return Photo::where([
                'storage' => $storage,
                'path' => $path
            ])->first();
        }
    }
}

if (! function_exists('create_user_with_photo')) {
    function create_user_with_photo($path) {

    }
}

if (! function_exists('create_person_with_photo')) {
    /**
     * Create Person with photo.
     *
     * @param $path
     * @return mixed
     */
    function create_person_with_photo($path = null) {
        if ( ! $path ) {
            $path = 'node_modules/admin-lte/dist/img/avatar.png';
        }
        $person = create(Person::class);
        add_photo_to_person($path, $person);
        return $person;
    }
}

if (! function_exists('add_photo_to_person')) {
    /**
     * Add photo to person.
     *
     * @param $path
     * @param $person
     */
    function add_photo_to_person($path, $person)
    {
        $filename = str_random(32) . '-' . $person->id .
        '-' . snake_case($person->name) . '.' . pathinfo($path, PATHINFO_EXTENSION);
        $photoPath = Storage::putFileAs(
            'user_photos', new \Illuminate\Http\File($path) ,
            $filename);
        $person->photos()->create([
            'storage' => 'local',
            'path' => $photoPath,
            'origin' => basename($path)
        ]);
    }
}

if (! function_exists('add_photo_to_first_user')) {
    /**
     * Add photo to first user.
     *
     * @param string $photo
     */
    function add_photo_to_first_user($photo = 'node_modules/admin-lte/dist/img/avatar.png')
    {
        $user = User::findOrFail(1);

        add_photo_to_user($user, $photo);
    }
}

if (! function_exists('add_photo_to_user')) {
    /**
     * Add photo to user.
     *
     * @param $user
     * @param string $photo
     */
    function add_photo_to_user($user, $photo = 'node_modules/admin-lte/dist/img/avatar.png')
    {
        $person = $user->person;
        if (! $person) {
            $person = create(Person::class);
            $user->persons()->attach($person);
        }
        add_photo_to_person($photo, $person);
    }
}


if (! function_exists('remove_photo_to_first_user')) {
    /**
     * Remove photo to _first_user
     */
    function remove_photo_to_first_user()
    {
        $user = User::findOrFail(1);
        remove_photo_to_user($user);
    }
}

if (! function_exists('remove_photo_to_user')) {
    /**
     * Remove photo to user
     */
    function remove_photo_to_user($user)
    {
        $person = $user->persons()->first();
        if ($person) {
            $photo = Photo::where('person_id',$person->id)->first();
            Storage::delete($photo->path);
            $user->persons()->detach();
        }
    }
}

if (! function_exists('create_nif_identifier')) {
    /**
     *Create NIF identifier.
     */
    function create_nif_identifier()
    {
        $faker = Factory::create('es_ES');

        $type = IdentifierType::firstOrCreate([
            'name' => 'NIF'
        ]);

        $identifier = Identifier::create([
            'value' => $faker->dni,
            'type_id' => $type->id
        ]);

        return $identifier;
    }
}

if (! function_exists('make_nif_identifier')) {
    /**
     * Make NIF identifier.
     */
    function make_nif_identifier()
    {
        $faker = Factory::create('es_ES');

        $type = IdentifierType::firstOrCreate([
            'name' => 'NIF'
        ]);

        $identifier = Identifier::make([
            'value' => $faker->dni,
            'type_id' => $type->id
        ]);

        return $identifier;
    }
}

if (! function_exists('create_person_with_nif')) {
    /**
     *Create person with NIF
     */
    function create_person_with_nif()
    {
        $person = factory(Person::class)->states('ca')->create();
        $id = create_nif_identifier();
        $person->identifier()->associate($id);
        $person->save();
        return $person;
    }
}

if (! function_exists('create_person')) {
    /**
     * Create person.
     *
     * @param null $identifier
     * @return array
     */
    function create_person($identifier = null) {
        $faker = Factory::create('es_ES');

        $gender = $faker->randomElements(['male', 'female']);
        $givenName = $faker->firstName($gender[0]);
        $surname1 = $faker->lastName;
        $surname2 = $faker->lastName;
        $birthplace = factory(Location::class)->create();

        $person = [
            'givenName' => $givenName,
            'surname1' => $surname1,
            'surname2' => $surname2,
            'birthdate' => $faker->date,
            'birthplace_id' => $birthplace->id,
            'birthplace' => $birthplace->name,
            'gender' => $gender[0],
            'civil_status' => random_civil_status(),
            'notes' => $faker->paragraph
        ];

        if ( $identifier ) {
            return array_merge (
                [
                    'identifier' => $identifier->value,
                    'identifier_id' => $identifier->id,
                    'identifier_type' => $identifier->type_id,
                ],
                $person
            );
        }

        return $person;
    }
}

if (! function_exists('create_person_with_nif_array')) {
    /**
     *Create person with NIF in array format
     */
    function create_person_with_nif_array()
    {
        $identifier = make_nif_identifier();
        return create_person($identifier);
    }
}

if (! function_exists('random_civil_status')) {
    function random_civil_status()
    {
        $faker = Factory::create();
        return $faker->randomElements(
            ['Soltero/a','Casado/a','Separado/a','Divorciado/a','Viudo/a']
        )[0];
    }
}

if (! function_exists('seed_relationships')) {
    function seed_relationships()
    {
        //Import from ebre-escool
        ///usr/bin/ssh -o StrictHostKeyChecking=no  -N -i /home/sergi/.ssh/id_rsa -L 14852:127.0.0.1:3306 -p 22 sergi@192.168.50.180

        seed_identifier_types();
        seed_contact_types();
        seed_identifiers();
        seed_provinces();
        seed_addresses();
        seed_contacts();
        seed_people();
    }
}
