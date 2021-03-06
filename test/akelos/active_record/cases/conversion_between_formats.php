<?php

require_once(dirname(__FILE__).'/../config.php');

class ConversionBetweenFormats_TestCase extends ActiveRecordUnitTest
{
    public $skip_fixtures = true;
    public function setup() {
        $this->installAndIncludeModels(array('Person','Account'));
    }

    public function test_simple_xml() {
        $person = new Person();
        $person->setAttributes(array('first_name'=>'Hansi','last_name'=>'Müller','email'=>'hans@mueller.com'));
        $expected = <<<EOX
<?xml version="1.0" encoding="UTF-8"?>
<person>
<id nil="true"></id>
<first-name>Hansi</first-name>
<last-name>Müller</last-name>
<email>hans@mueller.com</email>
<created-at type="datetime" nil="true"></created-at>
</person>
EOX;
        $xml = $person->toXml();

        $this->_compareXml($expected, $xml);

        $person_reloaded = $person->fromXml($xml);
        $this->assertEqual($person->first_name,$person_reloaded->first_name);
        $this->assertEqual($person->last_name,$person_reloaded->last_name);
    }

    public function test_with_relations_xml() {
        $person = $this->Person->create(array('first_name'=>'Hansi','last_name'=>'Müller','email'=>'hans@mueller.com'));
        $person_created_at = gmdate('Y-m-d\TH:i:s\Z', Ak::getTimestamp($person->created_at));
        $person->account->create(array('username'=>'hansi','password'=>'wilma'));
        $account_created_at = gmdate('Y-m-d\TH:i:s\Z', Ak::getTimestamp($person->account->created_at));
        $expected = <<<EOX
<?xml version="1.0" encoding="UTF-8"?>
<person>
<id type="integer">{$person->id}</id>
<first-name>Hansi</first-name>
<last-name>Müller</last-name>
<email>hans@mueller.com</email>
<created-at type="datetime">$person_created_at</created-at>
<account>
<id>{$person->account->id}</id>
<person-id type="integer">{$person->id}</person-id>
<username>hansi</username>
<password>wilma</password>
<is-enabled type="boolean">0</is-enabled>
<credit-limit type="integer" nil="true"></credit-limit>
<firm-id type="integer" nil="true"></firm-id>
<reset-key nil="true"></reset-key>
<created-at type="datetime">$account_created_at</created-at>
</account></person>
EOX;
        $xml = $person->toXml(array('include'=>'account'));

        $this->_compareXml($expected, $xml);

        $person_reloaded = $person->fromXml($xml);
        $this->assertEqual($person->first_name,$person_reloaded->first_name);
        $this->assertEqual($person->last_name,$person_reloaded->last_name);
        $this->assertEqual($person->account->id,$person_reloaded->account->id);
    }

    public function test_collection_and_back_xml() {
        $person = new Person();
        $p1=$person->create(array('first_name'=>'Hansi','last_name'=>'Müller','email'=>'hans@mueller.com'));
        $p1->account->create(array('username'=>'hansi','password'=>'wilma'));
        $person2 = new Person();
        $p2=$person2->create(array('first_name'=>'Friedrich','last_name'=>'Holz','email'=>'friedel@holz.de'));
        $p2->account->create(array('username'=>'friedrich','password'=>'wilma'));

        $xml = $person->toXml(array('collection'=>array($p1,$p2),'include'=>'account'));
        $people_reloaded = $person->fromXml($xml);

        $this->assertEqual($p1->first_name,$people_reloaded[0]->first_name);
        $this->assertEqual($p2->first_name,$people_reloaded[1]->first_name);

        $this->assertEqual($p1->account->id,$people_reloaded[0]->account->id);
        $this->assertEqual($p2->account->id,$people_reloaded[1]->account->id);
    }

    public function test_simple_json() {
        $person = new Person();
        $person->setAttributes(array('first_name'=>'Hansi','last_name'=>'Müller','email'=>'hans@mueller.com'));
        $expected = <<<EOX
{"id":null,"first_name":"Hansi","last_name":"M\u00fcller","email":"hans@mueller.com","created_at":null}
EOX;
        $json = $person->toJson();

        $this->_compareJson($expected, $json);

        $person_reloaded = $person->fromJson($json);

        $this->assertEqual($person->first_name,$person_reloaded->first_name);
    }

    public function test_collection_json() {
        $person = new Person();
        $person->setAttributes(array('first_name'=>'Hansi','last_name'=>'Müller','email'=>'hans@mueller.com'));

        $person2 = new Person();
        $person2->setAttributes(array('first_name'=>'Friedrich','last_name'=>'Holz','email'=>'friedel@holz.de'));

        $expected = <<<EOX
[{"id":null,"first_name":"Hansi","last_name":"M\u00fcller","email":"hans@mueller.com","created_at":null},{"id":null,"first_name":"Friedrich","last_name":"Holz","email":"friedel@holz.de","created_at":null}]
EOX;
        $json = $person->toJson(array($person,$person2));

        $this->_compareJson($expected, $json);

        $people_reloaded = $person->fromJson($json);

        $this->assertEqual($person->first_name,$people_reloaded[0]->first_name);
        $this->assertEqual($person2->first_name,$people_reloaded[1]->first_name);
    }

    public function test_collection_and_back_json() {
        $person = new Person();
        $p1=$person->create(array('first_name'=>'Hansi','last_name'=>'Müller','email'=>'hans@mueller.com'));
        $p1->account->create(array('username'=>'hansi','password'=>'wilma'));
        $p2=$person->create(array('first_name'=>'Friedrich','last_name'=>'Holz','email'=>'friedel@holz.de'));
        $p2->account->create(array('username'=>'hansi','password'=>'wilma'));


        $json = $person->toJson(array('collection'=>array($p1,$p2),'include'=>'account'));

        $people_reloaded = $person->fromJson($json);

        $this->assertEqual($p1->first_name,$people_reloaded[0]->first_name);
        $this->assertEqual($p2->first_name,$people_reloaded[1]->first_name);

        $this->assertEqual($p1->account->id,$people_reloaded[0]->account->id);
        $this->assertEqual($p2->account->id,$people_reloaded[1]->account->id);
    }

    public function test_with_relations_json() {
        $person = $this->Person->create(array('first_name'=>'Hansi','last_name'=>'Müller','email'=>'hans@mueller.com'));
        $person_created_at = gmdate('Y-m-d\TH:i:s\Z', Ak::getTimestamp($person->created_at));
        $person->account->create(array('username'=>'hansi','password'=>'wilma'));
        $account_created_at = gmdate('Y-m-d\TH:i:s\Z', Ak::getTimestamp($person->account->created_at));

        $expected = <<<EOX
{"id":$person->id,"first_name":"Hansi","last_name":"M\u00fcller","email":"hans@mueller.com","created_at":"{$person_created_at}","account":{"id":{$person->account->id},"person_id":{$person->id},"username":"hansi","password":"wilma","is_enabled":0,"credit_limit":null,"firm_id":null,"reset_key":null,"created_at":"{$account_created_at}"}}
EOX;
        $json = $person->toJson(array('include'=>'account'));
        $this->_compareJson($expected,$json);

        $person_reloaded = $person->fromJson($json);
        $this->assertEqual($person->first_name,$person_reloaded->first_name);
        $this->assertEqual($person->last_name,$person_reloaded->last_name);
        $this->assertEqual($person->account->id,$person_reloaded->account->id);
    }

    private function _compareXml($expected, $given)
    {
        $expected = Ak::convert('xml', 'array', $expected);
        $given = Ak::convert('xml', 'array', $given);
        $this->assertEqual($expected, $given);
    }

    private function _compareJson($expected, $given)
    {
        $expected = json_decode($expected, true);
        $given = json_decode($given, true);
        $this->assertEqual($expected, $given);
    }
}

ak_test_case('ConversionBetweenFormats_TestCase');

