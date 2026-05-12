package com.library.config;

import com.library.model.User;
import com.library.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.CommandLineRunner;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Component;

@Component
public class DataInitializer implements CommandLineRunner {

    @Autowired
    private UserRepository userRepository;

    @Autowired
    private BCryptPasswordEncoder passwordEncoder; // Inject the encoder

    @Override
    public void run(String... args) {
        if (userRepository.count() == 0) {
            createAdmin("lewis", "lewis123");
            createAdmin("icon", "icon123");
            createAdmin("adilex", "adilex123");
            System.out.println("✅ Admin accounts created: lewis, icon, adilex");
        }
    }

    private void createAdmin(String username, String password) {
        User user = new User();
        user.setUsername(username);
        user.setPassword(passwordEncoder.encode(password));
        user.setRole("ADMIN");
        userRepository.save(user);
    }
}