package com.vendorbear.web.api.card;

import com.vendorbear.schema.Card;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping(value = "/api/card")
public class CreateController {

    @RequestMapping(method = RequestMethod.GET, value = "/create")
    public Card findCard() {
        return new Card();
    }
}
