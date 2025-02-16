<?php

namespace App\Services\Ethereum;

use Web3\Web3;
use Web3\Contract;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;

class BaseETHService
{
    protected Web3 $web3;
    protected Contract $contract;
    protected string $contractAddress;
    protected string $privateKey;

    public function __construct()
    {
        $rpcUrl = config('ethereum.rpc_url');
        $this->contractAddress = config('ethereum.escrow_contract');
        $this->privateKey = config('ethereum.private_key');

        $this->web3 = new Web3(new HttpProvider(new HttpRequestManager($rpcUrl)));
        $this->contract = new Contract($this->web3->provider, config('ethereum.abi'));
    }
}