<?php

return [
    'rpc_url'                   => env('SOLANA_RPC_URL', 'https://api.mainnet-beta.solana.com'),
    'app_sol_private_key'       => env('APP_SOL_PRIVATE_KEY'),
    'solana_network'            =>  env('SOLANA_NETWORK', 'localnet'),
    'solana_keypair_path'       =>  env('SOLANA_KEYPAIR_PATH', '' ?? trim(shell_exec('solana config get --keypair | awk \'{print $2}\''))),
    
];
