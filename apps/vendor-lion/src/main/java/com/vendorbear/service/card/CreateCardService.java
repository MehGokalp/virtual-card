package com.vendorbear.service.card;

import com.vendorbear.entitiy.Card;
import com.vendorbear.repository.CardRepository;
import org.springframework.stereotype.Service;

@Service
public class CreateCardService extends AbstractCardService {
    public CreateCardService(CardRepository cardRepository) {
        super(cardRepository);
    }

    public Card create() {
        return new Card();
    }
}
