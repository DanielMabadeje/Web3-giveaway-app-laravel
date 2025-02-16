# Documentation

To create a unique escrow account per giveaway, there are two main options:

1️⃣ Deploy a New Smart Contract Per Giveaway (Costly)
Each time a giveaway is created, deploy a new instance of the escrow contract, making the giveaway fully isolated.

Pros: Each giveaway has its own secure contract.
Cons: Gas fees can be expensive since each giveaway requires a separate deployment.
2️⃣ Use a Single Smart Contract with Per-Giveaway Tracking (Recommended)
Modify the smart contract so it can create and track multiple escrow accounts internally.

Each giveaway would have a unique identifier (e.g., giveaway ID or seed).
Funds would be mapped inside the smart contract to track who owns what.
Release of funds would reference the specific giveaway’s balance.

## Ethereum APPlication Binary Interface

The storage/ethereum_abi.json file is expected to contain the ABI (Application Binary Interface) of your Ethereum smart contract. This file is usually generated during the smart contract compilation process.

How to Get the ethereum_abi.json File?
Option 1: If You Have the Smart Contract Code
If you have access to the smart contract's Solidity (.sol) code, you can generate the ABI file using Hardhat, Truffle, or Remix.

### Using Hardhat

Compile Your Smart Contract
Run the following inside your Hardhat project:

``` sh

    npx hardhat compile

```

The ABI will be generated in:

``` bash

    artifacts/contracts/{YourContract}.sol/{YourContract}.json

```

Extract and Save the ABI

1. Open the artifacts/contracts/{YourContract}.sol/{YourContract}.json file.
2. Copy only the "abi" part.
3. Save it as storage/ethereum_abi.json in your Laravel project.

### Using Truffle

- Compile Your Smart Contract

``` sh

    truffle compile

```

- Find the ABI
The ABI will be located in:

``` bash
    build/contracts/{YourContract}.json
```

- Extract the "abi" and save it in storage/ethereum_abi.json.

### Using Remix

- Open your contract in Remix.
- Click Compile (Ctrl + S).
- Go to the compile tab and find the ABI section.
- Copy the ABI and save it in storage/ethereum_abi.json.

- Option 2: If the Smart Contract is Already Deployed
    If the smart contract is deployed on Sepolia, Ethereum Mainnet, or any EVM-compatible chain, you can fetch the ABI from Etherscan.

### Steps to Get ABI from Etherscan

- Visit Sepolia Etherscan.
- Search for your escrow contract address.
- Scroll down to the Contract section and click "Read Contract".
- Click "ABI" and copy the JSON.
- Save it as storage/ethereum_abi.json in your Laravel project.
