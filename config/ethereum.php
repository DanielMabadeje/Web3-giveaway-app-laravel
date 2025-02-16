<?php

return [
    'rpc_url' => env('ETH_RPC_URL', 'https://sepolia.infura.io/v3/YOUR_INFURA_PROJECT_ID'),
    'escrow_contract' => env('ETH_ESCROW_CONTRACT'),
    'private_key' => env('ETH_PRIVATE_KEY'),
    'owner_address' => env('ETH_OWNER_ADDRESS'),
    'abi' => file_get_contents(base_path('storage/app/public/ethereum_abi.json') ?? base_path('storage/ethereum_demo_abi.json')),
];
