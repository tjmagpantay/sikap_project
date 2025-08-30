<?php
// All data should come from the controller, not direct model access
// The controller has already prepared all necessary data

// Include the specific step view
include __DIR__ . '/profile-completion/complete-profile-step' . $step . '.php';