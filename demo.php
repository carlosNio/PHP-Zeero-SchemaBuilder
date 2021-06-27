<?php

use Zeero\SchemaBuilder\Alter;
use Zeero\SchemaBuilder\Schema;
use Zeero\SchemaBuilder\Table;

// custom autoloader
require_once "Zeero/autoload.php";

/**
 *  N O T E
 * 
 * all Schema methos return sql string by default , if you want to execute that actions
 * you must to pass a PDO instance to method < connection >> of the Schema class before any operation
 * 
 * note again: before any operation
 */


$pdo = new PDO('...' , '...' , '...');

// we want to execute
Schema::connection($pdo);




/** Table Creation */

$sql = Schema::create('User', function (Table $table) {
    $table->primary(); //by default: ID
    $table->string('name')->unique(); // size by default: 100
    $table->string('password')->size(255);
    $table->enum('level', [1, 2, 3])->default(3);
    // you can change the engine 'InnoDb' by default
    $table->engine('MyIsam');
    // you can also change the character set 'utf-8' by default
    $table->charset('utf-16');
});



/** Alter Table */

$sql = Schema::alter('User', function (Alter $alter) {

    $alter->add(function (Table $t) {
        // creating new columns
        $t->datetime('created_at');
        // ....
    });


    $alter->modifyColumn(function (Table $t) {
        // modify column level
        $t->enum('level', [1, 2, 3])->default(1);
        // ....
    });

    $alter->change(function (Table $t) {
        // modify column level
        $t->enum('level', [1, 2, 3])->default(1);
        // ....
    } , 'user_level'); // if is more than one pass a array


    // add a index
    $alter->addIndex('name_index' , 'name');
    // drop a index
    $alter->dropIndex('name_index');
    // drop the primaryKey
    $alter->dropPrimary();
   
    // rename the table
    $alter->rename('user_tbl');
});



/** DROP A Table */

Schema::drop('User');
// or
Schema::dropIfExists('user');


/** TRUNCATE A Table */

Schema::truncate('User');