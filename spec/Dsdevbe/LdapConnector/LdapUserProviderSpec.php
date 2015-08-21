<?php

namespace spec\Dsdevbe\LdapConnector;

use Dsdevbe\LdapConnector\Adapter\LdapInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LdapUserProviderSpec extends ObjectBehavior
{
    function let(LdapInterface $interface)
    {
        $this->beConstructedWith($interface);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Dsdevbe\LdapConnector\LdapUserProvider');
    }

    function it_validate_user_by_credentials(LdapInterface $interface)
    {
        $user = [
            'username' => 'john.doe@example.com',
            'password' => 'johnpassdoe',
        ];

        $interface->connect($user['username'], $user['password'])->shouldBeCalled();
        $this->retrieveByCredentials($user);
    }

    function it_retrieves_user_by_id(LdapInterface $interface)
    {
        $identifier = 'john.doe@example.com';

        $interface->getUserInfo($identifier)->shouldBeCalled();

        $this->retrieveById($identifier);
    }
}
