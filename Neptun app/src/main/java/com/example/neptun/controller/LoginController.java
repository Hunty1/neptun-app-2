package com.example.neptun.controller;

import com.example.neptun.model.User;
import com.example.neptun.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.Optional;

@RestController
@RequestMapping("/api/login")
public class LoginController {

    @Autowired
    private UserRepository userRepository;

    @PostMapping
    public ResponseEntity<String> login(@RequestBody User loginRequest) {
        // Felhasználó lekérése az adatbázisból
        Optional<User> userOptional = userRepository.findByUsername(loginRequest.getUsername());

        if (userOptional.isPresent()) {
            User user = userOptional.get();
            // Jelszó ellenőrzése
            if (user.getPassword().equals(loginRequest.getPassword()) && "STUDENT".equals(user.getRole())) {
                return ResponseEntity.ok("Sikeres bejelentkezés, diák felhasználó: " + user.getUsername());
            } else {
                return ResponseEntity.status(403).body("Hibás jelszó vagy nem diák felhasználó!");
            }
        } else {
            return ResponseEntity.status(404).body("Felhasználó nem található!");
        }
    }
}
