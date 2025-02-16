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
